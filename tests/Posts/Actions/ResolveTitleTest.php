<?php

namespace Tests\Posts\Actions;

use App\Posts\Actions\ResolveTitle;
use PHPUnit\Framework\TestCase;

class ResolveTitleTest extends TestCase
{
    public function test_resolve_title(): void
    {
        $this->assertSame('About developer experience', new ResolveTitle()('https://www.youtube.com/watch?v=rIxEiUhvGJ4'));
        $this->assertSame('Vendor locked | Stitcher.io', new ResolveTitle()('https://stitcher.io/blog/vendor-locked'));
        $this->assertSame('Why Optimistic Merging Works Better - Hintjens.com', new ResolveTitle()('http://hintjens.com/blog:106'));
    }
}
