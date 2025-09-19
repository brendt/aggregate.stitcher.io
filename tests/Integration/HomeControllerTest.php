<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Authentication\Role;
use App\Posts\PostState;
use App\Posts\SourceState;
use Tempest\DateTime\DateTime;
use Tests\Factories\PostFactory;
use Tests\Factories\SourceFactory;
use Tests\IntegrationTest;

final class HomeControllerTest extends IntegrationTest
{
    public function test_home_only_shows_published_posts(): void
    {
        $post = new PostFactory()
            ->withTitle('Pending')
            ->make();

        new PostFactory()
            ->withTitle('Denied')
            ->withState(PostState::DENIED)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('Pending')
            ->assertNotSee('Denied');

        $post->update(
            state: PostState::PUBLISHED,
            title: 'Published',
        );

        $this->http->get('/')
            ->assertOk()
            ->assertSee('Published');
    }
    
    public function test_pending_posts_are_shown_to_admins(): void
    {
        $this->login(role: Role::ADMIN);

        new PostFactory()
            ->withTitle('Pending')
            ->withState(PostState::PENDING)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertSee('Pending');
    }

    public function test_pending_posts_for_denied_sources_are_not_shown_to_admins(): void
    {
        $this->login(role: Role::ADMIN);

        $source = new SourceFactory()
            ->withState(SourceState::DENIED)
            ->make();

        new PostFactory()
            ->withTitle('Pending')
            ->withState(PostState::PENDING)
            ->withSource($source)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('Pending');
    }

    public function test_pending_posts_for_pending_sources_are_not_shown_to_admins(): void
    {
        $this->login(role: Role::ADMIN);

        $source = new SourceFactory()
            ->withState(SourceState::PENDING)
            ->make();

        new PostFactory()
            ->withTitle('Pending')
            ->withState(PostState::PENDING)
            ->withSource($source)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('Pending');
    }

    public function test_published_posts_with_future_publication_date_are_not_shown(): void
    {
        $this->clock('2025-01-01 00:00:00');

        new PostFactory()
            ->withTitle('Published')
            ->withState(PostState::PUBLISHED)
            ->withPublicationDate(DateTime::parse('2025-01-02 00:00:00'))
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('Published');

        $this->clock('2025-01-02 00:00:00');

        $this->http->get('/')
            ->assertOk()
            ->assertSee('Published');
    }
}
