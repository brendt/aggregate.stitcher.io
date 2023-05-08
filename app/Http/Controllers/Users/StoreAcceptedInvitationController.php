<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\EmailMatchesRule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StoreAcceptedInvitationController extends Controller
{
    public function __invoke(Request $request, string $code)
    {
        $invitedUser = User::query()
            ->where('invitation_code', $code)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', new EmailMatchesRule($invitedUser->email)],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::query()
            ->where('invitation_code', $code)
            ->where('email', $validated['email'])
            ->whereNull('password')
            ->firstOrFail();

        $user->update([
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->action(HomeController::class, [
            'message' => "Welcome to Aggregate, {$user->name}!"
        ]);
    }
}
