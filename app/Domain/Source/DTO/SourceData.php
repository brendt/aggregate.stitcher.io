<?php

namespace Domain\Source\DTO;

use App\Http\Requests\SourceRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SourceData extends DataTransferObject
{
    /** @var string */
    public $url;

    public static function fromRequest(SourceRequest $request): SourceData
    {
        return new self([
            'url' => $request->get('url'),
        ]);
    }
}
