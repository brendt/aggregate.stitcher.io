<?php

namespace App\Http\Rules;

use Domain\Source\DTO\LanguageRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class SupportedLanguageRule implements Rule
{
    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct()
    {
        $this->languageRepository = new LanguageRepository(base_path('app/languages.json'));
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
