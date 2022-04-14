<?php

namespace App\Jobs;

use App\Models\Source;
use App\Models\SourceState;
use Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Throwable;

class PublishSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Source $source
    ) {
    }

    public function handle()
    {
        $feedUrls = $this->getPossibleUrls($this->source->url);

        foreach ($feedUrls as $feedUrl) {
            try {
                Feed::load($feedUrl);

                if (Source::query()
                    ->where('url', $feedUrl)
                    ->whereNot('id', $this->source->id)
                    ->exists()
                ) {
                    $this->source->update([
                        'url' => $feedUrl,
                        'state' => SourceState::DUPLICATE,
                    ]);

                    return;
                }

                $this->source->update([
                    'url' => $feedUrl,
                    'state' => SourceState::PUBLISHED,
                ]);

                dispatch(new SyncSourceJob($this->source));

                return;
            } catch (Throwable) {
                continue;
            }

            $this->source->update([
                'state' => SourceState::INVALID,
            ]);
        }
    }

    private function getPossibleUrls(string $url): array
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);

        $host = parse_url($url, PHP_URL_HOST);

        return array_filter([
            $this->urlFromContent($url),
            $url,
            "{$scheme}://{$host}/feed.xml",
            "{$scheme}://{$host}/index.xml",
            "{$scheme}://{$host}/atom.xml",
            "{$scheme}://{$host}/rss.xml",

            "{$scheme}://{$host}/feed",
            "{$scheme}://{$host}/index",
            "{$scheme}://{$host}/atom",
            "{$scheme}://{$host}/rss",

            "{$scheme}://{$host}/blog/feed.xml",
            "{$scheme}://{$host}/blog/index.xml",
            "{$scheme}://{$host}/blog/atom.xml",
            "{$scheme}://{$host}/blog/rss.xml",

            "{$scheme}://{$host}/blog/feed",
            "{$scheme}://{$host}/blog/index",
            "{$scheme}://{$host}/blog/atom",
            "{$scheme}://{$host}/blog/rss",
            "{$scheme}://{$host}/blog/feed.atom",

            "{$scheme}://feed.{$host}",
            "{$scheme}://rss.{$host}",
        ]);
    }

    private function urlFromContent(string $url): ?string
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $html = @file_get_contents($url);

        if (! $html) {
            $host = parse_url($url, PHP_URL_HOST);

            $html = @file_get_contents("{$scheme}://{$host}");
        }

        if (! $html) {
            return null;
        }

        $dom = new Dom();

        $dom->loadStr($html);

        [$link] = $dom->find('head link[type="application/rss+xml"]');

        if (! $link || ! $link->href) {
            return null;
        }

        $href = $link->href;

        if (! Str::startsWith($href, 'http')) {
            $href = $scheme . '://' . preg_replace('/^[\/]+/', '', $href);
        }

        return $href;
    }
}
