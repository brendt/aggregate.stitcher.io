<?php

namespace Domain\Post\Models;

use Domain\Model;
use Domain\Post\Query\PostQueryBuilder;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Support\HasUuid;

class Post extends Model
{
    use HasUuid;

    protected $casts = [
        'date_created' => 'datetime',
        'vote_count' => 'integer',
        'view_count' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function (Post $post) {
            if ($post->date_created === null) {
                $post->date_created = now();
            }

            return $post;
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

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
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
            ->where('sources.is_active', true);
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
}
