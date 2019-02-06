<?php

namespace Tests\Domain\Mute;

use Domain\Mute\Actions\MuteAction;
use Domain\Mute\Actions\UnmuteAction;
use Domain\Mute\Models\Mute;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Tests\TestCase;

class MuteTest extends TestCase
{
    /** @var \Domain\User\Models\User */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_can_mute_a_muteable(): void
    {
        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        (new MuteAction())->__invoke($this->user, $source);

        $this->user->refresh();

        $this->assertTrue($this->user->hasMuted($source));
    }

    /** @test */
    public function it_can_unmute_a_muteable(): void
    {
        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        Mute::create([
            'user_id' => $this->user->id,
            'muteable_type' => $source->getMuteableType(),
            'muteable_uuid' => $source->uuid,
        ]);

        $this->assertTrue($this->user->hasMuted($source));

        (new UnmuteAction())->__invoke($this->user, $source);

        $this->user->refresh();

        $this->assertFalse($this->user->hasMuted($source));
    }
}
