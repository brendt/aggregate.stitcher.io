<?php

namespace Domain\Post\Decorators;

use Carbon\Carbon;
use Zend\Feed\Reader\Entry\AbstractEntry;

class RssEntryDecorator extends AbstractEntry
{
    /** @var \Zend\Feed\Reader\Entry\AbstractEntry|\Zend\Feed\Reader\Entry\EntryInterface */
    private $decoratedEntry;

    public function __construct(AbstractEntry $entry)
    {
        $this->decoratedEntry = $entry;

        parent::__construct($entry->entry, $entry->entryKey, $entry->data['type']);
    }

    public function createdAt(): Carbon
    {
        $date = $this->data['datecreated']
            ?? $this->data['datemodified']
            ?? null;

        if (!$date && $this->entry->getElementsByTagName('updated')->length > 0) {
            $date = $this->entry->getElementsByTagName('updated')->item(0)->lastChild->textContent;
        }

        if (!$date && $this->entry->getElementsByTagName('pubDate')->length > 0) {
            $date = $this->entry->getElementsByTagName('pubDate')->item(0)->lastChild->textContent;
        }

        if (!$date) {
            $date = now();
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
}
