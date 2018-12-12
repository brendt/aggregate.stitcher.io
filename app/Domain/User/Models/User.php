<?php

namespace Domain\User\Models;

use App\Support\HasUuid;
use Domain\Post\Models\Post;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;

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
        'is_active' => 'boolean',
        'is_super_admin' => 'boolean',
        'allow_emails' => 'boolean',
        'must_reset_password' => 'boolean',
        'password_updated_at' => 'datetime',
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

    public function getPrimarySource(): ?Source
    {
        return $this->sources->first();
    }
}
