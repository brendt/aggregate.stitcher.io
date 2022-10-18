<?php

namespace App\Models;

class RejectionReason
{
    public function __construct(
        public readonly string $message,
    ) {}

    public static function mute(string $word): self
    {
        return new self("Muted word: {$word}");
    }

    public static function isReply(): self
    {
        return new self("Is reply");
    }

    public static function isMention(): self
    {
        return new self("Is mention");
    }

    public static function otherLanguage(?string $language): self
    {
        return new self("Other language: {$language}");
    }

    public static function retweetedFromSearch(): self
    {
        return new self("Retweeted from search");
    }
}
