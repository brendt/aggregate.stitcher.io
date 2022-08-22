<?php declare(strict_types=1);

namespace App\Actions;

use App\Models\Tweet;
use DonatelloZa\RakePlus\RakePlus;

final class ParseTweetText
{
    public function __invoke(Tweet $tweet): Tweet
    {
        $text = $tweet->text;

        $keywords = RakePlus::create($text)->get();

        foreach ($keywords as $keyword) {
            $text = str_replace(
                search: $keyword,
                replace: "<em>{$keyword}</em>",
                subject: $text
            );
        }

        $tweet->update([
            'parsed_text' => $text,
        ]);

        return $tweet;
    }
}
