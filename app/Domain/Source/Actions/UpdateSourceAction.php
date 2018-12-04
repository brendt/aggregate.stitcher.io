<?php

namespace Domain\Source\Actions;

use Domain\Post\Actions\CreatePostAction;
use Domain\Post\Actions\UpdatePostAction;
use Domain\Post\DTO\PostData;
use Domain\Source\Models\Source;
use Zend\Feed\Reader\Reader;

class UpdateSourceAction
{
    /** @var \Domain\Post\Actions\CreatePostAction */
    protected $createPost;

    /** @var \Domain\Post\Actions\UpdatePostAction */
    protected $updatePost;

    public function __construct(
        CreatePostAction $createPost,
        UpdatePostAction $updatePost
    ) {
        $this->createPost = $createPost;
        $this->updatePost = $updatePost;
    }

    public function execute(Source $source)
    {
        $feed = Reader::import($source->url);

        foreach ($feed as $entry) {
            $postData = PostData::create($entry);

            /** @var \Domain\Post\Models\Post $post */
            $post = $source->posts()->where('url', $postData->url)->first();

            if (! $post) {
                $this->createPost->execute($source, $postData);

                continue;
            }

            $this->updatePost->execute($post, $postData);
        }
    }
}
