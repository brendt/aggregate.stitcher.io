<?php

namespace Tests\Factories;

use Domain\Post\Decorators\RssEntryDecorator;
use Domain\Post\Models\Tag;
use Zend\Feed\Reader\Entry\AbstractEntry;
use Zend\Feed\Reader\Reader;

class RssEntryDecoratorFactory
{
    public static function new(): RssEntryDecoratorFactory
    {
        return new self();
    }

    public function create(string $content): RssEntryDecorator
    {
        $entry = $this->createEntry($content);

        return new RssEntryDecorator($entry, Tag::all());
    }

    public function createEntry(string $content): AbstractEntry
    {
        $feed = Reader::importString(
            <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>test</title>
        $content
    </channel>
</rss>
XML
        );

        return $feed->current();
    }
}
