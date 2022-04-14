<?php

declare(strict_types=1);

namespace App\Http\Controllers;

final class SuggestSourceController
{
    public function __invoke()
    {
        return view('suggestSource');
    }
}
