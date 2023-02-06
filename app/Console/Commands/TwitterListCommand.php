<?php

namespace App\Console\Commands;

use Cache;
use DG\Twitter\Twitter;
use Illuminate\Console\Command;

class TwitterListCommand extends Command
{
    protected $signature = 'twitter:list';

    public function handle(Twitter $twitter)
    {
        $members = Cache::remember('twitter:list', now()->addHour(), fn () => $twitter->request('lists/members.json', 'GET', [
            'list_id' => config('services.twitter.list_id'),
            'count' => 200,
            'tweet_mode' => 'extended',
        ]));

        $file = fopen(__DIR__ . '/members.csv', 'w');

        fputcsv($file, ['handle', 'follower_count', 'url']);

        foreach ($members->users as $user) {
            $data = [
                'handle' => $user->screen_name,
                'follower_count' => $user->followers_count,
                'url' => "https://twitter.com/{$user->screen_name}",
            ];

            fputcsv($file, $data);
        }

        fclose($file);
    }
}
