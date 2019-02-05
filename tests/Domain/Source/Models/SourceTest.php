<?php

namespace Tests\Domain\Source\Models;

use Domain\Mute\Models\Mute;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Tests\TestCase;

class SourceTest extends TestCase
{
    /** @test */
    public function test_scope_where_not_muted(): void
    {
        /** @var \Domain\User\Models\User $user */
        $user = factory(User::class)->create();

        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        Mute::make($user, $source);

        $this->assertEquals(0, Source::whereNotMuted($user)->count());
    }
}
