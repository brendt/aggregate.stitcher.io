<?php

namespace Domain\Source\Models;

use App\Http\Controllers\SourceMutesController;
use Carbon\Carbon;
use Domain\Model;
use Domain\Mute\HasMutes;
use Domain\Mute\Muteable;
use Domain\Post\Models\Post;
use Domain\Post\Models\Topic;
use Domain\Source\QueryBuilders\SourceQueryBuilder;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Filterable;
use Support\HasUuid;

class Source extends Model implements Filterable, Muteable
{
    use HasUuid, HasMutes;

    protected $casts = [
        'is_active' => 'boolean',
        'is_validated' => 'boolean',
        'validation_failed_at' => 'datetime',
    ];

    public static function boot(): void
    {
        self::creating(function (Source $source): void {
            if ($source->website === null) {
                $source->website = parse_url($source->url, PHP_URL_HOST);
            }
        });

        parent::boot();
    }

    public function newEloquentBuilder($query)
    {
        return new SourceQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function sourceTopics(): HasMany
    {
        return $this->hasMany(SourceTopic::class);
    }

    public function topics(): HasManyThrough
    {
        return $this->hasManyThrough(
            Topic::class,
            SourceTopic::class,
            'source_id',
            'id',
            'id',
            'topic_id'
        );
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    public function getBaseUrl(): string
    {
        [$scheme, $host] = array_values(parse_url($this->url));

        return "{$scheme}://{$host}";
    }

    public function setUrlAttribute(string $url): void
    {
        if (! Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'http://' . $url;
        }

        $this->attributes['url'] = $url;
    }

    public function scopeWhereNotValidated(Builder $builder): Builder
    {
        return $builder->where('is_validated', false);
    }

    public function getPostByUrl(string $url): ?Post
    {
        foreach ($this->posts as $post) {
            if ($post->url !== $url) {
                continue;
            }

            return $post;
        }

        return null;
    }

    public function getFilterValue(): string
    {
        return $this->website;
    }

    public function getMuteableType(): string
    {
        return $this->getMorphClass();
    }

    public function getName(): string
    {
        return __(':website', ['website' => $this->website]);
    }

    public function getMuteUrl(): string
    {
        return action([SourceMutesController::class, 'store'], $this);
    }

    public function getUnmuteUrl(): string
    {
        return action([SourceMutesController::class, 'delete'], $this);
    }

    public function isInactive(): bool
    {
        return ! $this->is_active;
    }

    public function hasOtherPostOnSameDay(string $url, Carbon $date): bool
    {
        foreach ($this->posts()->get() as $post) {
            if ($post->url === $url) {
                continue;
            }

            if (! $post->date_created->isSameDay($date)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function markAsInvalid(): Source
    {
        $this->validation_failed_at = now();

        $this->save();

        return $this;
    }

    public function hasTopics(): bool
    {
        return $this->topics->isNotEmpty();
    }

    /**
     * @return \Illuminate\Support\Collection|\Domain\Post\Models\Tag[]
     */
    public function getTopicTags(): Collection
    {
        return $this->topics->flatMap(function (Topic $topic) {
            return $topic->tags;
        });
    }

    public function getPrimaryTopic(): ?Topic
    {
        return $this->topics->first();
    }

    public function getHost(): string
    {
        $scheme = parse_url($this->url, PHP_URL_SCHEME) ?? 'http';

        $host = parse_url($this->url, PHP_URL_HOST);

        return "{$scheme}://{$host}";
    }

    public function getFullPath(string $path): string
    {
        $host = $this->getHost();

        if (Str::startsWith($path, $host)) {
            return $path;
        }

        $path = ltrim($path, '/');

        return "{$host}/{$path}";
    }

    public function getAdminUrl(): string
    {
        return action([\App\Http\Controllers\AdminSourcesController::class, 'edit'], $this);
    }
}
