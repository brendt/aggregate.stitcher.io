<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Tweets\AdminTweetController;
use App\Models\Mute;
use Illuminate\Http\Request;

final class StoreMuteController
{
    public function __invoke(Request $request)
    {
        $text = $request->validate([
            'text' => ['string', 'required']
        ])['text'];

        Mute::create([
            'text' => $text,
        ]);

        return redirect()->action(AdminTweetController::class, ['message' => 'Mute created!']);
    }
}
