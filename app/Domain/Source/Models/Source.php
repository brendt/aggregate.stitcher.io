<?php

namespace Domain\Source\Models;

use Carbon\Carbon;
use Domain\Mute\HasMutes;
use Domain\Mute\Muteable;
use App\Http\Controllers\SourceMutesController;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Filterable;
use Support\HasUuid;
use Domain\Model;
use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model implements Filterable, Muteable
{
    use HasUuid, HasMutes;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        self::creating(function (Source $source) {
            if ($source->website === null) {
                $source->website = parse_url($source->url, PHP_URL_HOST);
            }
        });

        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
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
}
