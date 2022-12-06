<?php

namespace Tests\Feature;

use App\Http\Controllers\Posts\AdminPostsController;
use App\Http\Controllers\Posts\DenyPostController;
use App\Http\Controllers\Posts\PublishPostController;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use Tests\TestCase;

final class AdminPostTest extends TestCase
{
    /** @test */
    public function can_publish_post()
    {
        $this->login();
        $this->travelTo('2022-01-01');

        $post = Post::factory()->pending()->create([
            'title' => 'post a',
        ]);

        $this->post(action(PublishPostController::class, $post));

        $post = $post->refresh();

        $this->assertEquals(PostState::PUBLISHED, $post->state);
        $this->assertTrue(now()->eq($post->published_at));
        $this->assertTrue(now()->startOfDay()->eq($post->published_at_day));
    }

    /** @test */
    public function can_deny_post()
    {
        $this->login();
        $this->travelTo('2022-01-01');

        $post = Post::factory()->pending()->create([
            'title' => 'post a',
        ]);

        $this->post(action(DenyPostController::class, $post));

        $post->refresh();

        $this->assertEquals(PostState::DENIED, $post->state);
    }

    /** @test */
    public function only_pending_posts_are_shown_in_admin_view()
    {
        $this->login();

        Post::factory()
            ->count(3)
            ->sequence(
                ['state' => PostState::PUBLISHED, 'title' => 'post a'],
                ['state' => PostState::PENDING, 'title' => 'post b'],
                ['state' => PostState::DENIED, 'title' => 'post c'],
            )
            ->create([
                'source_id' => Source::factory()->published()->create()->id
            ]);

        $this->get(action(AdminPostsController::class))
            ->assertSuccessful()
            ->assertSee('post b')
            ->assertDontSee('post a')
            ->assertDontSee('post c');
    }

    /** @test */
    public function no_posts_from_pending_sources_are_shown_in_admin_view()
    {
        $this->login();

        Post::factory()
            ->count(3)
            ->sequence(
                ['state' => PostState::PUBLISHED, 'title' => 'post a'],
                ['state' => PostState::PENDING, 'title' => 'post b'],
                ['state' => PostState::DENIED, 'title' => 'post c'],
            )
            ->create([
                'source_id' => Source::factory()->pending()->create()->id
            ]);

        $this->get(action(AdminPostsController::class))
            ->assertSuccessful()
            ->assertDontSee('post b')
            ->assertDontSee('post a')
            ->assertDontSee('post c');
    }

    /** @test */
    public function no_posts_from_denied_sources_are_shown_in_admin_view()
    {
        $this->login();

        Post::factory()
            ->count(3)
            ->sequence(
                ['state' => PostState::PUBLISHED, 'title' => 'post a'],
                ['state' => PostState::PENDING, 'title' => 'post b'],
                ['state' => PostState::DENIED, 'title' => 'post c'],
            )
            ->create([
                'source_id' => Source::factory()->denied()->create()->id
            ]);

        $this->get(action(AdminPostsController::class))
            ->assertSuccessful()
            ->assertDontSee('post b')
            ->assertDontSee('post a')
            ->assertDontSee('post c');
    }
}
