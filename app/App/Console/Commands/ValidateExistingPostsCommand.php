<?php

namespace App\Console\Commands;

use Domain\Post\Models\Post;
use Illuminate\Console\Command;
use Zend\Http\Client;
use Zend\Http\Exception\RuntimeException;
use Zend\Http\Response;

final class ValidateExistingPostsCommand extends Command
{
    protected $signature = 'validate:posts';

    /** @var \Zend\Http\Client */
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        parent::__construct();

        $this->httpClient = $httpClient;
    }

    public function handle()
    {
        $posts = Post::query()->where('is_validated', false)->get();

        $total = $posts->count();

        $i = 1;

        foreach ($posts as $post) {
            $this->comment("Validating {$post->getFullUrl()} ({$i}/{$total})");

            $post->is_validated = $this->isValidated($post->getFullUrl());

            $post->save();

            $i++;
        }

        $this->info('Done');
    }

    private function isValidated(string $url): bool
    {
        try {
            $response = $this->httpClient->setUri($url)->send();
        } catch (RuntimeException $exception) {
            return false;
        }

        return $response->getStatusCode() === Response::STATUS_CODE_200;
    }
}
