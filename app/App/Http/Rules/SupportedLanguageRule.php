<?php

namespace App\Http\Rules;

use Domain\Language\LanguageRepository;
use Illuminate\Contracts\Validation\Rule;

class SupportedLanguageRule implements Rule
{
    /** @var \Domain\Language\LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function passes($attribute, $value): bool
    {
        return $this->languageRepository->has($value);
    }

    public function message()
    {
        return __("This language isn't supported.");
    }
}
