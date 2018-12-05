<?php

use App\Domain\Source\Events\CreateSourceEvent;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    public function run()
    {
        $sources = [
            'https://assertchris.io/feed' => 'chris@assertchris.io',
            'https://stitcher.io/rss' => 'brent@stitcher.io',
            'https://blog.cleancoder.com/atom' => 'unclebob@cleancoder.com',
            'https://sebastiandedeyne.com/feed' => 'sebastian@spatie.be',
        ];

        foreach ($sources as $url => $email) {
            $user = User::whereEmail($email)->firstOr(function () use ($email) {
                return factory(User::class)->create([
                    'email' => $email,
                ]);
            });

            event(new CreateSourceEvent(
                $url,
                $user->uuid
            ));
        }
    }
}
