<?php

namespace Domain\User\Actions;

use Domain\User\Models\UserInterest;

class CreateUserInterestAction
{
    public function __invoke(int $userId, int $topicId): UserInterest
    {
        return UserInterest::updateOrCreate([
            'user_id' => $userId,
            'topic_id' => $topicId,
        ]);
    }
}
