<?php

namespace Domain\User\Actions;

use Domain\Language\Language;
use Domain\User\Models\User;

class AddLanguageAction
{
    public function __invoke(User $user, Language $language): User
    {
        $userLanguages = $user->languages;

        $userLanguages[$language->code] = $language->code;

        $user->languages = $userLanguages;

        $user->save();

        return $user->refresh();
    }
}
