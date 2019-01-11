<?php

use Domain\Source\Events\CreateSourceEvent;
use Domain\User\Events\CreateUserEvent;
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
            'https://www.stilldrinking.org/rss/feed.xml' => 'info@stilldrinking.org',
            'https://codingwriter.com/feed/' => 'info@codingwriter.com',
            'https://murze.be/feed/originals' => 'freek@spatie.be',
            'https://gomakethings.com/feed/index.xml' => 'info@gomakethings.com',
            'https://sebastiandedeyne.com/feed' => 'sebastian@spatie.be',
            'https://bitsofco.de/rss/' => 'info@bitsofco.de',
            'https://flaviocopes.com/index.xml' => 'info@flaviocopes.com',
            'http://shortdiv.com/index.xml' => 'info@shortdiv.com',
            'https://rachelandrew.co.uk/feed' => 'info@rachelandrew.co.uk',
            'https://kinsta.com/feed/' => 'info@kinsta.com',
            'https://ohdear.app/feed' => 'info@ohdear.app',
            'https://jerguslejko.com/feed.xml' => 'info@jerguslejko.com',
        ];

        foreach ($sources as $url => $email) {
            $user = User::whereEmail($email)->firstOr(function () use ($email) {
                event(CreateUserEvent::create($email, bcrypt('secret')));

                return User::whereEmail($email)->first();
            });

            event(new CreateSourceEvent(
                $url,
                $user->uuid,
                true
            ));
        }
    }
}
