<?php

namespace Support\Rss;

use Zend\Feed\Exception\RuntimeException;
use Zend\Feed\Reader\Feed\FeedInterface;
use Zend\Feed\Reader\Reader as ZendReader;

class RssReader implements Reader
{
    public function import(string $url): FeedInterface
    {
        try {
            $feed = ZendReader::import($url);
        } catch (RuntimeException $exception) {
            if (strpos($exception->getMessage(), '403') === false) {
                throw $exception;
            }

            $feed = ZendReader::importString(file_get_contents($url));
        }

        return $feed;
    }
}
