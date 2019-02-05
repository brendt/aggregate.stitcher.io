<?php

namespace Tests\Domain\Post\Models;

use Domain\Mute\Models\Mute;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;
use Domain\Post\Models\Tag;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @var \Domain\User\Models\User */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function muted_tag_is_ignored(): void
    {
        /** @var \Domain\Post\Models\Tag $tag */
        $tag = factory(Tag::class)->create();

        $post = factory(Post::class)->create();

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        Mute::make($this->user, $tag);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }

    /** @test */
    public function muted_tag_is_ignored_even_when_multiple_tags(): void
    {
        /** @var \Domain\Post\Models\Tag $tagA */
        $tagA = factory(Tag::class)->create([
            'name' => 'A',
        ]);

        /** @var \Domain\Post\Models\Tag $tagB */
        $tagB = factory(Tag::class)->create([
            'name' => 'B',
        ]);

        $post = factory(Post::class)->create();

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tagA->id,
        ]);

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tagB->id,
        ]);

        Mute::make($this->user, $tagA);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }

    /** @test */
    public function muted_source_is_ignored(): void
    {
        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        factory(Post::class)->create([
            'source_id' => $source->id,
        ]);

        Mute::make($this->user, $source);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }

    /** @test */
    public function muted_tag_with_unmuted_source_is_ignored(): void
    {
        /** @var \Domain\Post\Models\Tag $tag */
        $tag = factory(Tag::class)->create();

        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        $post = factory(Post::class)->create([
            'source_id' => $source->id,
        ]);

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        Mute::make($this->user, $tag);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }

    /** @test */
    public function muted_source_with_unmuted_tag_is_ignored(): void
    {
        /** @var \Domain\Post\Models\Tag $tag */
        $tag = factory(Tag::class)->create();

        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        $post = factory(Post::class)->create([
            'source_id' => $source->id,
        ]);

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        Mute::make($this->user, $source);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }

    /** @test */
    public function muted_source_with_muted_tag_is_ignored(): void
    {
        /** @var \Domain\Post\Models\Tag $tag */
        $tag = factory(Tag::class)->create();

        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        $post = factory(Post::class)->create([
            'source_id' => $source->id,
        ]);

        PostTag::create([
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        Mute::make($this->user, $source);

        Mute::make($this->user, $tag);

        $this->assertEquals(0, Post::whereNotMuted($this->user)->count());
    }
}
