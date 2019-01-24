<?php

namespace Tests\Mocks;

use DateTime;
use Tests\Factories\RssEntryDecoratorFactory;
use Zend\Feed\Reader\Collection\Category;
use Zend\Feed\Reader\Feed\FeedInterface;

class MockFeedInterface implements FeedInterface
{
    use IterableImplementation;

    public function withPost(string $url, array $extra = []): MockFeedInterface
    {
        $feed = clone $this;

        $date = $extra['date'] ?? '2019-01-01';

        $feed->array[] = RssEntryDecoratorFactory::new()->createEntry(
            <<<XML
<item>
    <title>$url</title>
    <updated>$date</updated>
    <description>description</description>
    <summary>summary</summary>
    <content>content</content>
    <link>$url</link>
</item>
XML
        );

        return $feed;
    }

    public function getAuthor($index = 0): string
    {
        return 'Author';
    }

    public function getAuthors(): array
    {
        return (array) $this->getAuthor();
    }

    public function getCopyright(): ?string
    {
        return null;
    }

    public function getDateCreated(): ?DateTime
    {
        return now();
    }

    public function getDateModified(): ?DateTime
    {
        return now();
    }

    public function getDescription(): ?string
    {
        return 'Description';
    }

    public function getGenerator(): ?string
    {
        return 'Generator';
    }

    public function getId(): ?string
    {
        return 'ID';
    }

    public function getLanguage(): ?string
    {
        return 'en';
    }

    public function getLink(): ?string
    {
        return config('app.url');
    }

    public function getFeedLink(): ?string
    {
        return config('app.url') . '/feed.xml';
    }

    public function getTitle(): ?string
    {
        return 'Title';
    }

    public function getCategories(): Category
    {
        return new Category(['Category A']);
    }
}
