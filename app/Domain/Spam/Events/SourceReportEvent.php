<?php

namespace Domain\Spam\Events;

use Domain\Spam\Models\Spam;
use Domain\User\Events\ChangeForUserEvent;
use Domain\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\DataTransferObject;

final class SourceReportEvent extends DataTransferObject implements ChangeForUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $spam;

    public static function new(Spam $spam): SourceReportEvent
    {
        return new self(
            [
                            'spam' => $spam,
                        ]);
    }

    public function getUser(): User
    {
        return $this->spam->user;
    }
}
