<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tweets;

final class CreateMuteController
{
    public function __invoke()
    {
        return view('createMute');
    }
}
