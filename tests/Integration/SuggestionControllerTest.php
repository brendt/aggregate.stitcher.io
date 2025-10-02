<?php

namespace Tests\Integration;

use App\Authentication\Role;
use App\Factories\SuggestionFactory;
use App\Posts\Post;
use App\Posts\Source;
use App\Suggestions\Suggestion;
use App\Suggestions\SuggestionController;
use Tempest\Core\DeferredTasks;
use Tests\IntegrationTestCase;
use function Tempest\Router\uri;

final class SuggestionControllerTest extends IntegrationTestCase
{
    public function test_make_suggestion(): void
    {
        $this->http
            ->post(uri([SuggestionController::class, 'suggest']), ['suggestion' => 'https://stitcher.io'])
            ->assertRedirect();

        $tasks = $this->container->get(DeferredTasks::class)->getTasks();
        $this->assertCount(1, $tasks);
        $task = $tasks[array_key_first($tasks)];
        $task();

        $suggestion = Suggestion::select()->first();

        $this->assertSame('https://stitcher.io', $suggestion->uri);
        $this->assertSame('https://stitcher.io/rss', $suggestion->feedUri);
    }

    public function test_deny_suggestion(): void
    {
        $this->login(role: Role::ADMIN);

        $suggestion = new SuggestionFactory()->make();

        $this->http
            ->post(uri([SuggestionController::class, 'deny'], suggestion: $suggestion->id))
            ->assertOk();

        $this->assertSame(0, Suggestion::count()->where('id', $suggestion->id)->execute());
    }

    public function test_public_suggestion_feed(): void
    {
        $this->login(role: Role::ADMIN);

        $suggestion = new SuggestionFactory()
            ->withFeedUri('https://stitcher.io/rss')
            ->make();

        $this->http
            ->post(uri([SuggestionController::class, 'publish'], suggestion: $suggestion->id) . '?feed')
            ->assertOk();

        $this->assertSame(0, Suggestion::count()->where('id', $suggestion->id)->execute());
        $source = Source::select()->where('uri', $suggestion->feedUri)->first();
        $this->assertNotNull($source);

        $posts = Post::select()->where('source_id', $source->id)->first();
        $this->assertNotEmpty($posts);
    }
}