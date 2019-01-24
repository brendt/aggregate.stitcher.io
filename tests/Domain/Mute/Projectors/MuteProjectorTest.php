<?php

namespace Tests\Domain\Mute\Projectors;

use Domain\Mute\Events\MuteEvent;
use Domain\Mute\Events\UnmuteEvent;
use Domain\Mute\Models\Mute;
use Domain\Mute\Projectors\MuteProjector;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Tests\TestCase;

class MuteProjectorTest extends TestCase
{
    /** @var \Domain\User\Models\User */
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $projectionist = app(\Spatie\EventProjector\Projectionist::class);

        $projectionist->replay(collect(MuteProjector::class));

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_can_mute_a_muteable()
    {
        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        event(MuteEvent::make($this->user, $source));

        $this->user->refresh();

        $this->assertTrue($this->user->hasMuted($source));
    }

    /** @test */
    public function it_can_unmute_a_muteable()
    {
        /** @var \Domain\Source\Models\Source $source */
        $source = factory(Source::class)->create();

        Mute::create([
            'user_id' => $this->user->id,
            'muteable_type' => $source->getMuteableType(),
            'muteable_uuid' => $source->uuid,
        ]);

        $this->assertTrue($this->user->hasMuted($source));

        event(UnmuteEvent::make($this->user, $source));

        $this->user->refresh();

        $this->assertFalse($this->user->hasMuted($source));
    }
}
