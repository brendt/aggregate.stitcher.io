<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;
use Domain\User\Models\UserInterest;
use Support\PageCache\PageCache;

class ResolveUserInterestsAction
{
    private CreateUserInterestAction $createUserInterestAction;

    public function __construct(
        CreateUserInterestAction $createUserInterestAction
    ) {
        $this->createUserInterestAction = $createUserInterestAction;
    }

    public function __invoke(User $user, array $topicIds): void
    {
        foreach ($topicIds as $topicId) {
            ($this->createUserInterestAction)($user->id, $topicId);
        }

        UserInterest::query()
            ->where('user_id', $user->id)
            ->whereNotIn('topic_id', $topicIds)
            ->delete();

        PageCache::flush($user);
    }
}
