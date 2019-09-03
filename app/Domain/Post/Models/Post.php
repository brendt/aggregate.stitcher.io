<?php

namespace Domain\Post\Models;

use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTweetController;
use Domain\Model;
use Domain\Post\Query\PostQueryBuilder;
use Domain\Source\Models\Source;
use Domain\Tweet\HasTweets;
use Domain\Tweet\Tweetable;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Support\HasUuid;

class Post extends Model implements Tweetable, Feedable
{
    use HasUuid, HasTweets;

    protected $casts = [
        'date_created' => 'datetime',
        'vote_count' => 'integer',
        'view_count' => 'integer',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function (Post $post) {
            if ($post->date_created === null) {
                $post->date_created = now();
            }

            return $post;
        });

        self::saving(function (Post $post) {
            $post->language = $post->source->language;
        });
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function votesThisWeek(): HasMany
    {
        return $this
            ->votes()
            ->whereDate('created_at', '>=', now()->subWeek());
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function viewsThisWeek(): HasMany
    {
        return $this
            ->views()
            ->whereDate('created_at', '>=', now()->subWeek());
    }

    public function tags(): HasManyThrough
    {
        return $this->hasManyThrough(
            Tag::class,
            PostTag::class,
            'post_id',
            'id',
            'id',
            'tag_id'
        );
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder
            ->distinct()
            ->join('sources', 'sources.id', '=', 'posts.source_id')
            ->where('sources.is_active', true)
            ->where('posts.is_validated', true);
    }

    public function scopeWhereUnread(Builder $builder, User $user): Builder
    {
        return $builder->whereDoesntHave('views', function (Builder $builder) use ($user) {
            return $builder->where('user_id', $user->id);
        });
    }

    public function scopeWhereNotMuted(Builder $builder, User $user): Builder
    {
        return $builder
            ->whereDoesntHave('source', function (Builder $builder) use ($user) {
                /** @var \Illuminate\Database\Eloquent\Builder|\Domain\Source\Models\Source $builder */
                return $builder->whereMuted($user);
            })
            ->whereDoesntHave('tags', function (Builder $builder) use ($user) {
                /** @var \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Tag $builder */
                return $builder->whereMuted($user);
            });
    }

    public function scopeWhereTopic(Builder $builder, Topic $topic): Builder
    {
        return $builder->whereHas('tags', function (Builder $builder) use ($topic) {
            /** @var \Domain\Post\Models\Tag $builder */
            return $builder->whereTopic($topic);
        });
    }

    public function scopeWhereNotTweeted(Builder $builder): Builder
    {
        return $builder->orWhereDoesntHave('tweets');
    }

    public function scopeWithActivePopularityIndex(Builder $builder): Builder
    {
        return $builder->where('popularity_index', '>=', 0);
    }

    public function scopeWhereLanguage(Builder $builder, string $language): Builder
    {
        return $builder->where('posts.language', $language);
    }

    public function scopeWhereLanguageIn(Builder $builder, Collection $languages): Builder
    {
        return $builder->whereIn('posts.language', $languages);
    }

    public function getTagById(int $tagId): ?Tag
    {
        foreach ($this->tags as $tag) {
            if ($tag->id !== $tagId) {
                continue;
            }

            return $tag;
        }

        return null;
    }

    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new PostQueryBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );
    }

    public function getRelativeDateAttribute(): string
    {
        $diffInSeconds = Carbon::now()
            ->diffInSeconds($this->date_created);

        if ($diffInSeconds < 60) {
            return 'Just now';
        }

        $diffInMinutes = round($diffInSeconds / 60);

        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' ' . str_plural('minute', $diffInMinutes) . ' ago';
        }

        $diffInHours = round($diffInMinutes / 60);

        if ($diffInHours < 24) {
            return $diffInHours . ' ' . str_plural('hour', $diffInHours) . ' ago';
        }

        $diffInDays = round($diffInHours / 24);

        if ($diffInDays < 30) {
            return $diffInDays . ' ' . str_plural('day', $diffInDays) . ' ago';
        }

        return $this->date_created->format('F jS, Y');
    }

    public function hasDifferentTags(array $tagIds): bool
    {
        $ownTagIds = $this->tags->pluck('id')->sort()->values()->toArray();

        $newTagIds = collect($tagIds)->sort()->values()->toArray();

        return $ownTagIds !== $newTagIds;
    }

    public function getTwitterStatus(): string
    {
        $url = action([PostsController::class, 'show'], $this);

        $status = trim($this->title);

        if ($this->source->twitter_handle) {
            $status .= " by {$this->source->twitter_handle}";
        }

        $status .= " {$url}";

        return $status;
    }

    public function getAdminTweetUrl(): string
    {
        return action(PostTweetController::class, $this);
    }

    public function getFullUrl(): string
    {
        $url = trim($this->url);

        if (Str::startsWith($url, 'http')) {
            return $url;
        }

        return $this->source->getFullPath($url);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->uuid)
            ->title($this->title)
            ->summary($this->teaser)
            ->updated($this->updated_at)
            ->link($this->getFullUrl())
            ->author($this->source->website);
    }

    public function savePopularityIndex(int $popularityIndex): Post
    {
        $this->popularity_index = $popularityIndex;

        $this->save();

        return $this;
    }
}
