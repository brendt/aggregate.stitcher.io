<?php

namespace App\Http\ViewModels;

use Domain\Source\DTO\Language;
use Domain\Source\DTO\LanguageRepository;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

class SourceViewModel extends ViewModel
{
    /** @var \Domain\User\Models\User */
    protected $user;

    /** @var LanguageRepository */
    protected $languageRepository;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->languageRepository = new LanguageRepository(base_path('app/languages.json'));
    }

    public function source(): ?Source
    {
        return $this->user->getPrimarySource();
    }

    public function url(): ?string
    {
        return optional($this->source())->url;
    }

    public function language(): ?string
    {
        return optional($this->source())->language;
    }

    /**
     * @return Language[]
     */
    public function languages(): array
    {
        return $this->languageRepository->all();
    }
}
