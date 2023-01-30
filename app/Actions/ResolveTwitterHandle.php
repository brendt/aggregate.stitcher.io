<?php

namespace App\Actions;

use App\Models\Source;
use Illuminate\Support\Facades\Log;

final readonly class ResolveTwitterHandle
{
    public function __invoke(Source $source): ?string
    {
        $handle = $this->resolveTwitterHandle($source);

        if (! $handle) {
            return null;
        }

        $handle = $this->trimHandle($handle);

        if (str_contains($handle, ' ')) {
            Log::info("[{$source->name}] skipped because handle contains spaces");
            return null;
        }

        if ($handle === '@') {
            Log::info("[{$source->name}] skipped because handle is empty");
            return null;
        }

        Log::info("[{$source->name}] {$handle}");

        $source->update([
            'twitter_handle' => $handle,
        ]);

        return $handle;
    }

    private function resolveTwitterHandle(Source $source): ?string
    {
        ['scheme' => $scheme, 'host' => $host] = parse_url($source->url);

        $url = "{$scheme}://{$host}";

        Log::info("[$source->name] trying from meta tags on {$url}");
        $meta = @get_meta_tags($url);
        Log::info(json_encode($meta, JSON_PRETTY_PRINT));

        $handleFromMeta = $meta['twitter:site']
            ?? $meta['twitter:creator']
            ?? null;

        if ($handleFromMeta) {
            Log::info("[$source->name] found handle in meta tags: {$handleFromMeta}");

            return $handleFromMeta;
        }

        Log::info("[$source->name] trying from HTML on {$url}");
        $html = @file_get_contents($url);

        if ($html) {
            preg_match(
                pattern: '/<a href="([^"]+)[^>]+>([^<]+)?(tweet|twitter)([^<]+)?/i',
                subject: $html,
                matches: $matches,
            );

            $handle = $matches[1] ?? null;

            if ($handle) {
                Log::info("[$source->name] found handle in HTML: {$handle}");

                return $handle;
            }
        }

        Log::info("[$source->name] nothing found");

        return null;
    }

    private function trimHandle(string $handle): string
    {
        $handle = trim($handle, ' /');

        $parts = explode('/', $handle);

        $handle = $parts[array_key_last($parts)];

        return '@' . ltrim($handle, '@');
    }
}
