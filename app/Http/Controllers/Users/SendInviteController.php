<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

final class SendInviteController
{
    public function __invoke(Request $request)
    {
        return view('sendInvite', [
            'message' => $request->get('message'),
        ]);
    }
}
