<?php

namespace App\Models;

use App\Http\Controllers\Posts\ShowPostController;
use Brendt\SparkLine\SparkLine;
use Brendt\SparkLine\SparkLineDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'type' => PostType::class,
        'state' => PostState::class,
        'visits' => 'integer',
        'published_at' => 'datetime',
        'last_comment_at' => 'datetime',
        'published_at_day' => 'date',
        'hide_until' => 'datetime',
    ];

    protected static function booted()
    {
        self::creating(function (Post $post) {
            $post->state ??= PostState::PENDING;
            $post->uuid ??= Uuid::uuid4()->toString();
        });

        self::saving(function (Post $post) {
            $post->published_at_day = $post->published_at;
        });
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class)->orderByDesc('created_at');
    }

    public function scopeHomePage(Builder|Post $query): void
    {
        $query
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->whereActiveSource()
            ->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ]);
    }

    public function isPending(): bool
    {
        return $this->state === PostState::PENDING;
    }

    public function isStarred(): bool
    {
        return $this->state === PostState::STARRED;
    }

    public function isDenied(): bool
    {
        return $this->state === PostState::DENIED;
    }

    public function isPublished(): bool
    {
        return $this->state === PostState::PUBLISHED;
    }

    public function isTweet(): bool
    {
        return $this->type === PostType::TWEET;
    }

    public function canDeny(): bool
    {
        return ! $this->isDenied();
    }

    public function canStar(): bool
    {
        return ! $this->isStarred();
    }

    public function canPublish(): bool
    {
        return ! $this->isStarred() && ! $this->isPublished();
    }

    public function getPublicUrl(): string
    {
        return action(ShowPostController::class, [
            'post' => $this->uuid,
        ]);
    }

    public function getFullUrl(): string
    {
        $host = parse_url($this->url, PHP_URL_HOST);

        if ($host !== null) {
            return $this->url;
        }

        $path = parse_url($this->url, PHP_URL_PATH);

        return "{$this->source->getBaseUrl()}/{$path}";
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->getPublicUrl())
            ->link($this->getPublicUrl())
            ->title($this->title)
            ->updated($this->created_at)
            ->summary('')
            ->authorName('')
            ->authorEmail('');
    }

    public static function getAllFeedItems(): Collection
    {
        return self::query()
            ->where('type', PostType::BLOG)
            ->where('state', PostState::PUBLISHED)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
    }

    public function scopeWhereActiveSource(Builder $builder): void
    {
        $builder->where(function (Builder $builder) {
            $builder
                ->whereHas('source', function (Builder $query) {
                    $query->where('state', SourceState::PUBLISHED);
                })
                ->orWhereNull('source_id');
        });
    }

    public function getSourceName(): string
    {
        if ($this->source) {
            return $this->source->name;
        }

        return parse_url($this->url, PHP_URL_HOST);
    }

    public function getShortSourceName(): string
    {
        $url = $this->source?->getBaseUrl() ?? parse_url($this->url, PHP_URL_HOST);

        return str_replace(['http://', 'https://', 'www.'], '', $url);
    }

    public function getParsedTitle(): string
    {
        return html_entity_decode($this->title);
    }

    public function getVisitsGraphCacheKey(): string
    {
        return "svg-{$this->uuid}";
    }

    public function getRankingCacheKey(): string
    {
        return "rank-{$this->uuid}";
    }

    public function getRanking(): PostRank
    {
        $posts = Cache::remember(
            'posts_ranking',
            now()->addSeconds(10),
            fn () => DB::query()
                ->select('id', 'visits')
                ->from($this->getTable())
                ->where('state', PostState::PUBLISHED->value)
                ->orderByDesc('visits')
                ->get()
        );

        $position = $posts->mapWithKeys(fn (object $row, int $position) => [$row->id => $position])[$this->id] ?? 0;

        return new PostRank(position: $position, total: $posts->count());
    }

    public function getSparkLine(): string
    {
        if (
            app()->environment('production')
            && ($cache = Cache::get($this->getVisitsGraphCacheKey()))
        ) {
            return $cache;
        }

        $days = DB::query()
            ->from((new PostVisit())->getTable())
            ->selectRaw('`created_at_day`, COUNT(*) as `visits`')
            ->where('post_id', $this->id)
            ->groupBy('created_at_day')
            ->orderByDesc('created_at_day')
//            ->limit(20)
            ->get()
            ->map(fn (object $row) => new SparkLineDay(
                count: $row->visits,
                day: Carbon::make($row->created_at_day),
            ));

        $sparkLine = SparkLine::new($days)
//            ->withMaxItemAmount(20)
            ->make();

        Cache::put(
            $this->getVisitsGraphCacheKey(),
            $sparkLine,
            now()->addDay(),
        );

        return $sparkLine;
    }

    public function getTweetMessage(): string
    {
        $message = $this->title;

        if ($handle = ($this->source->twitter_handle ?? null)) {
            $message .= " by {$handle}";
        }

        $message .= PHP_EOL . PHP_EOL . $this->getPublicUrl();

        return $message;
    }
}
