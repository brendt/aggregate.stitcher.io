<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\TagData;
use Domain\Post\Models\Tag;

final class SyncTagAction
{
    /** @var \Domain\Post\Actions\CreateTagAction */
    private $createTagAction;

    /** @var \Domain\Post\Actions\UpdateTagAction */
    private $updateTagAction;

    public function __construct(
        CreateTagAction $createTagAction,
        UpdateTagAction $updateTagAction
    ) {
        $this->createTagAction = $createTagAction;
        $this->updateTagAction = $updateTagAction;
    }

    public function __invoke(TagData $tagData): void
    {
        $existingTag = Tag::whereName($tagData->name)->first();

        if ($existingTag) {
            $this->updateTagAction->__invoke($existingTag, $tagData);

            return;
        }

        $this->createTagAction->__invoke($tagData);
    }
}
