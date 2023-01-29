<?php

namespace App\Actions;

use App\Models\Source;

final class ResolveSourceName
{
    public function __invoke(Source $source): string
    {
        if (str_contains($source->url, 'youtube.com')) {
            $contents = file_get_contents($source->url);

            preg_match(
                pattern: '/<title>([^<]+)/',
                subject: $contents,
                matches: $matches,
            );

            return $matches[1] ?? $source->url;
        }

        return $source->getBaseUrl();
    }
}
