<?php

namespace Domain\Source\DTO;

use App\Http\Requests\SourceRequest;
use Domain\Source\Models\Source;
use Spatie\DataTransferObject\DataTransferObject;

final class SourceData extends DataTransferObject
{
    /** @var string */
    public $url;

    /** @var int */
    public $user_id;

    /** @var bool */
    public $is_active;

    public static function fromRequest(SourceRequest $request, Source $source = null): SourceData
    {
        return new self([
            'url' => $request->get('url'),
            'user_uuid' => $source->user_id ?? $request->user()->id,
            'is_active' => $source->is_active ?? false,
        ]);
    }

    public function hasChanges(Source $source): bool
    {
        return $source->url !== $this->url;
    }
}
