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
                ->reject(function (Language $language) {
                    return array_key_exists($language->code, $this->user->languages);
                })
                ->mapWithKeys(function (Language $language) {
                    return [$language->code => $language->name];
                })
                ->toArray()
        );
    }

    public function languages(): Collection
    {
        return collect($this->user->languages)
            ->map(function (string $language) {
                return $this->languageRepository->find($language);
            });
    }
}
