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

    public function getParsedTitle(): string
    {
        return html_entity_decode($this->title);
    }

    public function getVisitsGraphCacheKey(): string
    {
        return "svg-{$this->uuid}";
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
            ->limit(20)
            ->get()
            ->map(fn (object $row) => new SparkLineDay(
                count: $row->visits,
                day: Carbon::make($row->created_at_day),
            ));

        $maxValue = DB::query()
            ->selectRaw("COUNT(*) AS `visits`, `created_at_day`, `post_id`")
            ->from((new PostVisit)->getTable())
            ->groupByRaw('`created_at_day`, `post_id`')
            ->orderByDesc('visits')
            ->limit(1)
            ->get('visits');

        $maxValue = ($maxValue[0] ?? null)?->visits;

        $sparkLine = SparkLine::new($days)
            ->withMaxItemAmount(20)
            ->withMaxValue($maxValue)
            ->make();

        Cache::put(
            $this->getVisitsGraphCacheKey(),
            $sparkLine,
            now()->addDay(),
        );

        return $sparkLine;
    }
}
