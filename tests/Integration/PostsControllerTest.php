<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Authentication\Role;
use App\Factories\PostFactory;
use App\Posts\PostsController;
use App\Posts\PostState;
use Tempest\DateTime\DateTime;
use Tests\IntegrationTestCase;
use function Tempest\Router\uri;

final class PostsControllerTest extends IntegrationTestCase
{
    public function test_queue_finds_the_correct_future_publication_date(): void
    {
        $this->login(role: Role::ADMIN);

        $this->clock('2025-01-01 00:00:00');

        new PostFactory()
            ->withState(PostState::PUBLISHED)
            ->withPublicationDate(DateTime::parse('2025-01-02 00:00:00'))
            ->times(5)
            ->make();

        $post = new PostFactory()
            ->withState(PostState::PENDING)
            ->make();

        $this->http->post(uri([PostsController::class, 'queue'], post: $post->id))
            ->assertOk();

        $post->refresh();

        $this->assertSame(PostState::PUBLISHED, $post->state);
        $this->assertNotNull($post->publicationDate);
        $this->assertTrue($post->publicationDate->equals('2025-01-03 00:00:00'));
    }

    public function test_publish_now_set_publication_date(): void
    {
        $this->login(role: Role::ADMIN);

        $this->clock('2025-01-01 10:00:00');

        new PostFactory()
            ->withState(PostState::PUBLISHED)
            ->withPublicationDate(DateTime::parse('2025-01-02 00:00:00'))
            ->times(5)
            ->make();

        $post = new PostFactory()
            ->withState(PostState::PENDING)
            ->make();

        $this->http->post(uri([PostsController::class, 'publish'], post: $post->id))
            ->assertOk();

        $post->refresh();

        $this->assertSame(PostState::PUBLISHED, $post->state);
        $this->assertNotNull($post->publicationDate);
        $this->assertTrue($post->publicationDate->equals('2025-01-01 10:00:00'));
    }
}
