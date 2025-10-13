<?php

namespace Tests\Posts\Actions;

use App\Posts\Actions\ResolveTitle;
use PHPUnit\Framework\TestCase;

class ResolveTitleTest extends TestCase
{
    public function test_resolve_title(): void
    {
        $this->assertSame('Vendor locked - stitcher.io', new ResolveTitle()('https://stitcher.io/blog/vendor-locked'));
        $this->assertSame('Why Optimistic Merging Works Better - Hintjens.com', new ResolveTitle()('http://hintjens.com/blog:106'));
    }
}
