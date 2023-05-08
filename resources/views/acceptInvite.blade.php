@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full grid gap-4 mt-4">
        <div class="text-sm text-center text-gray-400">
            <a class="underline hover:no-underline" href="{{ action(\App\Http\Controllers\HomeController::class) }}">
                back
            </a>
        </div>

        <div class="bg-white mx-4 shadow-md grid">
            @if($message ?? null)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <form method="POST"
                  action="{{ action(\App\Http\Controllers\Users\StoreAcceptedInvitationController::class, ['code' => $code]) }}">
                @csrf
                <div class="px-12 p-4 grid gap-2">
                    <h1 class="text-xl font-bold mt-2">
                        Join Aggregate!
                    </h1>

                    <p>
                        You've been invited by {{ $user->invitedBy->name }} to join Aggregate! Please confirm your email address, pick a display name and password, and you're done!
                    </p>

                    <label for="email" class="mt-2">
                        Email address:
                    </label>

                    <div class="grid">
                        <input type="text" id="email" name="email" value="{{ old('email') }}"/>

                        @error('email')
                        <span class="text-red-600">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <label for="name"  class="mt-2">
                        Display name:
                    </label>

                    <div class="grid">
                        <input type="text" id="name" name="name" value="{{ old('name') }}"/>

                        @error('name')
                        <span class="text-red-600">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <label for="password" class="mt-2">
                        Password:
                    </label>

                    <div class="grid">
                        <input type="password" id="password" name="password" value="{{ old('password') }}"/>

                        @error('password')
                        <span class="text-red-600">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <label for="password_confirmation" class="mt-2">
                        Confirm your password:
                    </label>

                    <div class="grid">
                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}"/>

                        @error('password_confirmation')
                        <span class="text-red-600">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <input type="submit" value="Join!"
                       class="w-full px-12 py-4 font-bold block text-center hover:bg-pink-200 cursor-pointer">
            </form>
        </div>
    </div>
@endcomponent
