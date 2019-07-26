<?php

namespace Domain\Language;

use Spatie\DataTransferObject\DataTransferObject;

final class Language extends DataTransferObject
{
    /** @var string */
    public $code;

    /** @var string */
    public $name;

    /** @var string */
    public $native;

    public function __construct(string $code, string $name, string $native)
    {
        parent::__construct([
            'code' => $code,
            'name' => $name,
            'native' => $native,
        ]);
    }
}
