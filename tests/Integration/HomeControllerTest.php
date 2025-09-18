<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Posts\PostState;
use Tests\Factories\PostFactory;
use Tests\Factories\SourceFactory;
use Tests\IntegrationTest;

/**
 * @internal
 */
final class HomeControllerTest extends IntegrationTest
{
    public function test_home(): void
    {
        $source= new SourceFactory()->make();

        $posts = new PostFactory()
            ->withTitle('Hello World')
            ->withSource($source)
            ->make();

        $this->http->get('/')
            ->assertOk()
            ->assertNotSee('Hello World');

        $posts[0]->update(
            state: PostState::PUBLISHED,
        );

        $this->http->get('/')
            ->assertOk()
            ->assertSee('Hello World');
    }
}
