<?php

namespace App\Posts\Actions;

use function Tempest\Support\str;

final class ResolveTitle
{
    public function __invoke(string $uri): string
    {
        $meta = get_meta_tags($uri);

        $title = $meta['title']
            ?? $meta['twitter:title']
            ?? $meta['og:title']
            ?? null;

        if (! $title) {
            $content = @file_get_contents($uri);
            $content = str($content ?? '');
            $title = $content->between('<title>', '</title>');
        }

        if (! $title) {
            $title = $uri;
        }

        $title = preg_replace_callback("/(&#[0-9]+;)/", function ($match) {
            return mb_convert_encoding($match[1], "UTF-8", "HTML-ENTITIES");
        }, $title);

        return trim(html_entity_decode(html_entity_decode($title)));
    }
}