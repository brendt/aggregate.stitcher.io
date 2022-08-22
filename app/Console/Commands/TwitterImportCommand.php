<?php

namespace App\Console\Commands;

use DG\Twitter\Twitter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TwitterImportCommand extends Command
{
    protected $signature = 'twitter:import {from}';

    private Twitter $twitter;

    public function handle(Twitter $twitter)
    {
        $this->twitter = $twitter;

        $fromName = $this->argument('from');

        $following = [];

        $nextCursor = -1;

        do {
            $page = Cache::remember(
                key: "friends-list-{$fromName}-{$nextCursor}",
                ttl: now()->addMinutes(15),
                callback: fn () => $twitter->request('friends/list.json', 'GET', [
                    'screen_name' => $fromName,
                    'count' => 200,
                    'cursor' => $nextCursor,
                ]),
            );

            $following = [...$following, ...$page->users];

            $nextCursor = $page->next_cursor;
        } while ($nextCursor);

        $following = collect($following)
            ->reject(fn (object $item) => $item->followers_count < 1000)
            ->sortByDesc(fn (object $item) => $item->followers_count);

        $totalCount = $following->count();

        $currentCount = 1;

        foreach ($following as $item) {
            $this->comment(PHP_EOL . "{$currentCount}/{$totalCount}");
            $this->addToList($item);
            $currentCount += 1;
        }
    }

    private function addToList(object $item): void
    {
        $screenName = $item->screen_name;

        if ($this->existsInList($screenName)) {
            $this->comment("<fg=green>{$screenName} already in list</>");

            return;
        }

        $cacheKey = "deny-list-{$screenName}";

        if (Cache::get($cacheKey)) {
            $this->comment("<fg=red>Skipped {$screenName}</>");

            return;
        }

        $this->comment("Add <fg=green>{$screenName}</>?");

        $followersCount = number_format($item->followers_count);
        $this->comment("Followers: $followersCount");
        $this->comment("Description: {$item->description}");

        $this->ask('Continue?');

        Cache::rememberForever($cacheKey, fn () => true);

        $this->comment("<fg=red>Skipped {$screenName}</>" . PHP_EOL);
    }

    private function existsInList(string $screenName): bool
    {
        $membersInList = Cache::remember(
            key: "list-members",
            ttl: now()->addMinute(),
            callback: fn () => $this->twitter->request(
                'lists/members.json',
                'GET',
                [
                    'list_id' => config('services.twitter.list_id'),
                    'count' => 5000,
                ],
            ));

        $members = collect($membersInList->users);

        return $members
                ->first(function ($item) use ($screenName) {
                    return $item->screen_name === $screenName;
                }) !== null;
    }
}
