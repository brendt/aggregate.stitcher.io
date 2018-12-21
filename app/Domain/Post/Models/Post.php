<?php

namespace Domain\Post\Models;

use App\Domain\Post\Collections\PostCollection;
use App\Domain\Post\Query\PostQueryBuilder;
use App\Support\HasUuid;
use Domain\Model;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Pagination\Paginator;

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
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );
    }
}
