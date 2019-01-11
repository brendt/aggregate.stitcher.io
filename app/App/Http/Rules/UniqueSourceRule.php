<?php

namespace App\Http\Rules;

use Domain\Source\Models\Source;
use Illuminate\Contracts\Validation\Rule;

class UniqueSourceRule implements Rule
{
    /** @var string */
    protected $currentSourceId;

    public function __construct(?string $currentSourceId = null)
    {
        $this->currentSourceId = $currentSourceId;
    }

    public function passes($attribute, $value): bool
    {
        $query = Source::query()
            ->whereUrl($value)
            ->where('id', '<>', $this->currentSourceId);

        return $query->count() === 0;
    }

    public function message(): string
    {
        return __('This source already exists.');
    }
}
