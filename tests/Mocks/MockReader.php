<?php

namespace Tests\Mocks;

use Support\Rss\Reader;
use Zend\Feed\Reader\Feed\FeedInterface;

final class MockReader implements Reader
{
    /** @var \Zend\Feed\Reader\Feed\FeedInterface */
    private $feedInterface;

    public static function new(): MockReader
    {
        return new self();
    }

    public function __construct()
    {
        $this->feedInterface = new MockFeedInterface();
    }

    public function withPost(string $url = '/test', array $extra = []): MockReader
    {
        $this->feedInterface = $this->feedInterface->withPost($url, $extra);

        return $this;
    }

    public function import(string $url): FeedInterface
    {
        return $this->feedInterface;
    }
}
