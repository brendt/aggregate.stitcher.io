<?php

namespace App\Feed\Controllers;

use Support\Markdown;

final class AboutController
{
    public function __invoke(Markdown $markdown)
    {
        $about = $markdown->load('about');

        return view('about', [
            'about' => $about,
        ]);
    }
}
