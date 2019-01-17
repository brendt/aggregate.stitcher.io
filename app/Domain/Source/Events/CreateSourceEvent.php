<?php

namespace Domain\Source\Events;

use App\Http\Requests\SourceRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateSourceEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $url;

    /** @var string */
    public $user_uuid;

    /** @var bool */
    public $is_active;

    public function __construct(string $url, string $user_uuid, bool $is_active = false){}
    {
        $this->url = $url;
        $this->user_uuid = $user_uuid;
        $this->is_active = $is_active;
    }

    public static function fromRequest(SourceRequest $request): CreateSourceEvent
    {
        return new self($request->get('url'), $request->user()->uuid);
    }
}
