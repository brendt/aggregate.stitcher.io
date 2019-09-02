<?php

namespace Domain\Post\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Events\PostCreatedEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;
use Domain\Source\Models\Source;
use Zend\Http\Client;
use Zend\Http\Exception\RuntimeException;
use Zend\Http\Response;

final class CreatePostAction
{
    /**
     * @var \Zend\Http\Client
     */
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __invoke(Source $source, PostData $postData): void
    {
        $post = Post::create(array_merge([
            'source_id' => $source->id,
            'is_validated' => $this->isValidated($postData),
        ], $postData->except('tag_ids')->toArray()));

        foreach ($postData->tag_ids as $tag_id) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag_id,
            ]);
        }

        $source->post_count = $source->posts()->count();

        $source->save();

        event(PostCreatedEvent::create($post, $postData->toArray()));
    }

    private function isValidated(PostData $postData): bool
    {
        try {
            $response = $this->httpClient->setUri($postData->url)->send();
        } catch (RuntimeException $exception) {
            return false;
        }

        return $response->getStatusCode() === Response::STATUS_CODE_200;
    }
}
