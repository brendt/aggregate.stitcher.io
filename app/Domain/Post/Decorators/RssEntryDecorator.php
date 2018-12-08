<?php

namespace Domain\Post\Decorators;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Zend\Feed\Reader\Entry\AbstractEntry;

class RssEntryDecorator extends AbstractEntry
{
    /** @var \Zend\Feed\Reader\Entry\AbstractEntry|\Zend\Feed\Reader\Entry\EntryInterface */
    private $decoratedEntry;

    /** @var \Illuminate\Support\Collection|\Domain\Post\Models\Tag[] */
    protected $tags;

    public function __construct(AbstractEntry $entry, Collection $tags)
    {
        $this->decoratedEntry = $entry;
        $this->tags = $tags;

        parent::__construct($entry->entry, $entry->entryKey, $entry->data['type']);
    }

    public function createdAt(): ?Carbon
    {
        $date = $this->data['datecreated']
            ?? $this->data['datemodified']
            ?? null;

        if (! $date && $this->entry->getElementsByTagName('updated')->length > 0) {
            $date = $this->entry->getElementsByTagName('updated')->item(0)->lastChild->textContent;
        }

        if (! $date && $this->entry->getElementsByTagName('pubDate')->length > 0) {
            $date = $this->entry->getElementsByTagName('pubDate')->item(0)->lastChild->textContent;
        }

        return Carbon::make($date);
    }

    public function title(): string
    {
        return strip_tags($this->decoratedEntry->getTitle());
    }

    public function url(): string
    {
        return $this->decoratedEntry->getLink();
    }

    public function tags(): Collection
    {
        $content = strip_tags($this->getContent());

        $foundTags = [];

        foreach ($this->tags as $tag) {
            $foundTags[$tag->id] = [];

            foreach ($tag->keywords as $keyword) {
                $matches = [];

                preg_match_all("/[^a-z]{$keyword}[^a-z]/i", $content, $matches);

                $foundTags[$tag->id][$keyword] = count($matches[0]);
            }
        }

        return collect($foundTags)
            ->map(function (array $keywords) {
                return array_reduce($keywords, function (?int $sum, int $current) {
                    $sum = $sum ?? 0;

                    return $sum + $current;
                });
            })
            ->filter(function (int $count) {
                return $count > 0;
            })
            ->sortByDesc(function (int $count) {
                return $count;
            })
            ->take(2)
            ->map(function (int $count, int $id) {
                return $id;
            });
    }

    private function getContent(): string
    {
        if ($this->entry->getElementsByTagName('summary')->length > 0) {
            return $this->entry->getElementsByTagName('summary')->item(0)->lastChild->textContent;
        }

        if ($this->entry->getElementsByTagName('description')->length > 0) {
            return $this->entry->getElementsByTagName('description')->item(0)->lastChild->textContent;
        }

        return '';
    }
}
