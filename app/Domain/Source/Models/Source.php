<?php

namespace Domain\Source\Models;

use App\Domain\Mute\Muteable;
use App\Http\Controllers\SourceMutesController;
use App\Support\Filterable;
use App\Support\HasUuid;
use Domain\Model;
use Domain\Mute\Models\Mute;
use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Source extends Model implements Filterable, Muteable
{
    use HasUuid;

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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function mutes(): MorphMany
    {
        return $this->morphMany(
            Mute::class,
            'muteable',
            'muteable_type',
            'muteable_uuid',
            'uuid'
        );
    }

    public function scopeWhereActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    public function scopeWhereNotMuted(Builder $builder, User $user): Builder
    {
        return $builder->whereDoesntHave('mutes', function (Builder $builder) use ($user) {
            /** @var \Domain\Mute\Models\Mute $builder */
            return $builder->whereUser($user);
        });
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getMuteableType(): string
    {
        return $this->getMorphClass();
    }

    public function getName(): string
    {
        return __(':website', ['website' => $this->website]);
    }

    public function getUnmuteUrl(): string
    {
        return action([SourceMutesController::class, 'delete'], $this);
    }
}
