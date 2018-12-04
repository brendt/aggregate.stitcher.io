<?php

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
        ];

        foreach ($sources as $url => $email) {
            $user = User::whereEmail($email)->firstOr(function () use ($email) {
                return factory(User::class)->create([
                    'email' => $email,
                ]);
            });

            Source::create([
                'url' => $url,
                'user_id' => $user->id,
                'is_active' => true,
            ]);
        }
    }
}
