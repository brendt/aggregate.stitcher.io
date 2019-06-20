<?php

namespace Domain\Source\Events;

use App\Http\Requests\SourceRequest;
use Domain\Source\Models\Source;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UpdateSourceEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $source_uuid;

    /** @var string */
    public $url;

    /** @var string|null */
    public $language;

    public function __construct(string $source_uuid, string $url, ?string $language)
    {
        $this->source_uuid = $source_uuid;
        $this->url = $url;
        $this->language = $language;
    }

    public static function fromRequest(
        Source $source,
        SourceRequest $request
    ): UpdateSourceEvent {
        return new self($source->uuid, $request->get('url'), $request->get('language'));
    }

    public function hasChanges(Source $source): bool
    {
        return $source->url !== $this->url;
    }
}
