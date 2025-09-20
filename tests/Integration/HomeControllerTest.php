<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Authentication\Role;
use App\Factories\PostFactory;
use App\Factories\SourceFactory;
use App\Factories\SuggestionFactory;
use App\Posts\PostState;
use App\Posts\SourceState;
use Tempest\DateTime\DateTime;
use Tests\IntegrationTestCase;

final class HomeControllerTest extends IntegrationTestCase
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

    public function test_queue_button_only_shows_when_there_are_five_or_more_published_posts_today(): void
    {
        $this->login(role: Role::ADMIN);
        $this->clock('2025-01-01 10:10:10');

        new PostFactory()
            ->withState(PostState::PENDING)
            ->make();

        new PostFactory()
            ->withState(PostState::PUBLISHED)
            ->withPublicationDate(DateTime::parse('2025-01-01 00:00:00'))
            ->times(4)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertSee('publish')
            ->assertNotSee('queue');

        new PostFactory()
            ->withState(PostState::PUBLISHED)
            ->withPublicationDate(DateTime::parse('2025-01-01 14:00:00'))
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertSee('queue')
            ->assertNotSee('publish');
    }

    public function test_admin_sees_suggestions(): void
    {
        new SuggestionFactory()
            ->withUri('suggestion.com')
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('suggestion.com');

        $this->login(role: Role::ADMIN);

        $this->http->get('/')
            ->assertOk()
            ->assertSee('suggestion.com');
    }
}
