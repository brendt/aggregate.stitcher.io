<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostShareSnooze;
use App\Services\PostSharing\SharingChannel;
use Illuminate\Http\Request;

final class SnoozeShareController
{
    public function __invoke(Post $post, string $channel, Request $request)
    {
        $channel = SharingChannel::from($channel);

        PostShareSnooze::create([
            'post_id' => $post->id,
            'channel' => $channel,
            'snooze_until' => $request->has('permanent')
                ? now()->addYears(100)
                : now()->addMonths(2),
        ]);

        if ($back = $request->get('back')) {
            return redirect()->to($back);
        }

        return redirect()->action(FindPostController::class, ['filter' => $channel->value]);
    }
}
