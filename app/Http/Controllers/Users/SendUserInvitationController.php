<?php

namespace App\Http\Controllers\Users;

use App\Mail\UserInvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

final class SendUserInvitationController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::create([
            'invited_by' => $request->user()->id,
            'invitation_code' => Uuid::uuid4()->toString(),
            'email' => $validated['email'],
        ]);

        Mail::to($user)->send(new UserInvitationMail($user));

        return redirect()->action(SendInviteController::class, [
            'message' => 'Your invitation has been sent!'
        ]);
    }
}
