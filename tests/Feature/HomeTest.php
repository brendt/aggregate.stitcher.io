<?php

namespace Tests\Feature;

use App\Http\Controllers\HomeController;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use Tests\TestCase;

final class HomeTest extends TestCase
{
    /** @test */
    public function only_published_posts_are_shown()
    {
        Post::factory()
            ->count(3)
            ->sequence(
                ['state' => PostState::PUBLISHED, 'title' => 'post a'],
                ['state' => PostState::DENIED, 'title' => 'post b'],
                ['state' => PostState::PENDING, 'title' => 'post c'],
            )
            ->create();

        $this->get(action(HomeController::class))
            ->assertSuccessful()
            ->assertSee('post a')
            ->assertDontSee('post b')
            ->assertDontSee('post c');
    }

    /** @test */
    public function posts_are_shown_in_publication_date_order()
    {
        Post::factory()
            ->count(2)
            ->published()
            ->sequence(
                ['title' => 'post a', 'published_at' => now()->subDays(3)],
                ['title' => 'post b', 'published_at' => now()->subDays(2)],
            )
            ->create();

        $this->get(action(HomeController::class))
            ->assertSuccessful()
            ->assertSeeInOrder([
                'post b',
                'post a',
            ]);
    }

    /** @test */
    public function only_published_source_posts_are_shown()
    {
        Post::factory()
            ->count(3)
            ->sequence(
                ['state' => PostState::PUBLISHED, 'title' => 'post a', 'source_id' => Source::factory()->published()->create()->id],
                ['state' => PostState::PUBLISHED, 'title' => 'post b', 'source_id' => Source::factory()->pending()->create()->id],
                ['state' => PostState::PUBLISHED, 'title' => 'post c', 'source_id' => Source::factory()->denied()->create()->id],
            )
            ->create();

        $this->get(action(HomeController::class))
            ->assertSuccessful()
            ->assertSee('post a')
            ->assertDontSee('post b')
            ->assertDontSee('post c');
    }
}
