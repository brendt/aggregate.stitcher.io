<?php

namespace Support;

use League\CommonMark\CommonMarkConverter;

final class Markdown
{
    /** @var \League\CommonMark\CommonMarkConverter */
    private $converter;

    /** @var string */
    private $content;

    public function __construct(CommonMarkConverter $converter)
    {
        $this->converter = $converter;
    }

    public function load(string $path): Markdown
    {
        $this->content = file_get_contents(resource_path("content/{$path}.md"));

        return $this;
    }

    public function __toString(): string
    {
        return $this->converter->convertToHtml($this->content);
    }
}
