<?php

namespace Support\Rss;

use Zend\Feed\Reader\Feed\FeedInterface;
use Zend\Feed\Reader\Reader as ZendReader;

class RssReader implements Reader
{
    public function import(string $url): FeedInterface
    {
        return ZendReader::import($url);
    }
}
