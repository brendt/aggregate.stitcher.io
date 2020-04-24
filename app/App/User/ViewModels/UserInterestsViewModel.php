<?php

namespace App\User\ViewModels;

use Domain\Post\Models\Topic;
use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

class UserInterestsViewModel extends ViewModel
{
    private User $user;

    public function __construct(User $user)
    {
        $user->load('interests');

        $this->user = $user;
    }

    public function interests(): array
    {
        return $this->user->interests
            ->mapWithKeys(fn (Topic $topic) => [$topic->id => $topic->name])
            ->toArray();
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(fn (Topic $topic) => [$topic->id => $topic->name])
            ->toArray();
    }
}
