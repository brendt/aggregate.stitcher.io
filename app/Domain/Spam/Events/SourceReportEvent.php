<?php

namespace Domain\Spam\Events;


use Domain\Post\Events\VoteCreatedEvent;
use Domain\Post\Models\Post;
use Domain\Post\Models\Spam;
use Domain\User\Events\ChangeForUserEvent;
use Domain\User\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\DataTransferObject;

 final class SourceReportEvent extends DataTransferObject implements ChangeForUserEvent

{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Domain\Post\Models\Spam */
    public $spam;

    public static function new(Spam $spam): SourceReportEvent
    {
        return new self([
                            'spam' => $spam,
                        ]);
    }

    public function getUser(): User
    {
        return $this->spam->user;
    }
}
