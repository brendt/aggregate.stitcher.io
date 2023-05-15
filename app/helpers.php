<?php

function getTitle(string $url): string
{
    $html = file_get_contents($url);

    preg_match('/<title[^>]*>(.*?)<\/title>/ims', $html, $match);

    return $match[1] ?? get_meta_tags($url)['title'] ?? $url;
}

function l(...$subject): void {
    foreach ($subject as $item) {
        \Log::debug(json_encode($item, JSON_PRETTY_PRINT));
    }
}
