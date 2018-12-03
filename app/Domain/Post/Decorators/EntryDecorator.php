<?php

namespace Domain\Post\Decorators;

use Carbon\Carbon;
use Zend\Feed\Reader\Entry\AbstractEntry;

class EntryDecorator extends AbstractEntry
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
            ?? $this->data['updated']
            ?? now();

        dd($this->entry->childNodes);
        
        return Carbon::make($date);
    }

    public function title(): string
    {
        return $this->decoratedEntry->getTitle();
    }

    public function url(): string
    {
        return $this->decoratedEntry->getLink();
    }
}
