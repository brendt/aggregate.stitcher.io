<?php

namespace Tests\Domain\Post\Models;

use Domain\Mute\Models\Mute;
use Domain\Post\Models\Tag;
use Domain\User\Models\User;
use Tests\TestCase;

class TagTest extends TestCase
{
    /** @test */
    public function test_scope_where_not_muted()
    {
        /** @var \Domain\User\Models\User $user */
        $user = factory(User::class)->create();

        /** @var \Domain\Post\Models\Tag $tag */
        $tag = factory(Tag::class)->create();

        Mute::make($user, $tag);

        $this->assertEquals(0, Tag::whereNotMuted($user)->count());
    }
}
