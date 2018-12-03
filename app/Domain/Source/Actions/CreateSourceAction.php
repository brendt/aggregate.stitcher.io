<?php

namespace Domain\Source\Actions;

use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Exception;

class CreateSourceAction
{
    public function execute(
        User $user,
        SourceData $sourceData
    ): Source {
        if ($user->sources->count() >= 1) {
            throw new Exception("User can only have one source");
        }

        return Source::create(array_merge([
            'user_id' => $user->id,
        ], $sourceData->all()));
    }
}
