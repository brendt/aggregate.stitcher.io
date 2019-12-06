<?php

namespace App\Http\ViewModels;

use Domain\Language\Language;
use Domain\Language\LanguageRepository;
use Domain\User\Models\User;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class ProfileViewModel extends ViewModel
{
    /** @var User */
    private $user;

    /** @var \Domain\Language\LanguageRepository */
    private $languageRepository;

    public function __construct(User $user, LanguageRepository $languageRepository)
    {
        $this->user = $user;
        $this->languageRepository = $languageRepository;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function languageOptions(): array
    {
        return array_merge(
            [null => ''],
            $this->languageRepository->all()
                ->reject(fn (Language $language) => $this->user->getLanguages()[$language->code] ?? false)
                ->mapWithKeys(fn (Language $language) => [$language->code => $language->name])
                ->toArray()
        );
    }

    public function languages(): Collection
    {
        return collect($this->user->languages)
            ->map(fn (string $language) => $this->languageRepository->find($language));
    }
}
