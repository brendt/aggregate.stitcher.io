<?php

namespace App\Http\Controllers;

use Support\Markdown;

final class PrivacyController
{
    public function __invoke(Markdown $markdown)
    {
        $privacy = $markdown->load('privacy');

        return view('privacy', [
            'privacy' => $privacy,
        ]);
    }
}
