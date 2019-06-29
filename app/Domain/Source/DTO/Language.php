<?php

namespace Domain\Source\DTO;

class Language
{
    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /** @var string */
    private $native;

    public function __construct(string $code, string $name, string $native)
    {
        $this->code = $code;
        $this->name = $name;
        $this->native = $native;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNative(): string
    {
        return $this->native;
    }
}
