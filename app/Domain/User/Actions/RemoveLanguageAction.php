<?php

namespace Domain\User\Actions;

use Domain\Language\Language;
use Domain\User\Models\User;

class RemoveLanguageAction
{
    public function __invoke(User $user, Language $language): User
    {
        $userLanguages = $user->languages;

        unset($userLanguages[$language->code]);

        $user->languages = $userLanguages;

        $user->save();

        return $user->refresh();
    }
}
