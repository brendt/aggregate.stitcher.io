<?php

namespace Support\Rss;

use Zend\Feed\Reader\Feed\FeedInterface;

interface Reader
{
    public function import(string $url): FeedInterface;
}
