<?php

namespace Domain\User\Models;

use Domain\Mute\Models\Mute;
use Domain\Mute\Muteable;
use Domain\Post\Models\Post;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Support\HasUuid;

class User extends BaseUser
{
    use Notifiable, HasUuid;

    protected $with = [
        'views',
        'votes',
    ];

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_verified' => 'boolean',
        'allow_emails' => 'boolean',
        'must_reset_password' => 'boolean',
        'password_updated_at' => 'datetime',
        'languages' => 'array',
    ];

    public function sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function mutes(): HasMany
    {
        return $this->hasMany(Mute::class);
    }

    public function scopeWhereAdmin(Builder $builder): Builder
    {
        return $builder->where('is_admin', true);
    }

    public function votedFor(Post $post): bool
    {
        foreach ($this->votes as $vote) {
            if ($vote->post_id === $post->id) {
                return true;
            }
        }

        return false;
    }

    public function hasViewed(Post $post): bool
    {
        foreach ($this->views as $view) {
            if ($view->post_id === $post->id) {
                return true;
            }
        }

        return false;
    }

    public function hasMuted(Muteable $muteable): bool
    {
        foreach ($this->mutes as $mute) {
            if ($mute->muteableEquals($muteable)) {
                return true;
            }
        }

        return false;
    }

    public function getPrimarySource(): ?Source
    {
        return $this->sources->first();
    }

    public function isVerified(): bool
    {
        return $this->is_verified === true;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function getLanguages(): Collection
    {
        return collect((array) $this->languages);
    }
}
