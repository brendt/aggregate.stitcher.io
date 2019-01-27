<?php

namespace Domain\Source\Events;

use App\Http\Requests\SourceRequest;
use Ramsey\Uuid\Uuid;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateSourceEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $source_uuid;

    /** @var string */
    public $url;

    /** @var string */
    public $user_uuid;

    /** @var bool */
    public $is_active;

    public function __construct(string $url, string $user_uuid, bool $is_active = false)
    {
        parent::__construct([
            'source_uuid' => (string) Uuid::uuid4(),
            'url' => $url,
            'user_uuid' => $user_uuid,
            'is_active' => $is_active,
        ]);
    }

    public static function fromRequest(SourceRequest $request): CreateSourceEvent
    {
        return new self($request->get('url'), $request->user()->uuid);
    }
}
