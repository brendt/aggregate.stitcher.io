<?php

namespace Tests\Domain\Post\Decorators;

use Domain\Post\Models\Tag;
use Tests\Factories\RssEntryDecoratorFactory;
use Tests\TestCase;

class RssEntryDecoratorTest extends TestCase
{
    /** @var \Tests\Factories\RssEntryDecoratorFactory */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('sync:tags');

        $this->factory = RssEntryDecoratorFactory::new();
    }

    /** @test */
    public function content_encoded_can_be_parsed(): void
    {
        $entry = $this->factory->create(
            <<<XML
<item>
    <title>A</title>
    <description>no match</description>
    <summary>no match</summary>
    <content>no match</content>
    <content:encoded>match</content:encoded>
</item>
XML
);

        $this->assertEquals('match', $entry->getContent());
    }

    /** @test */
    public function content_can_be_parsed(): void
    {
        $entry = $this->factory->create(
            <<<XML
<item>
    <title>A</title>
    <description>no match</description>
    <summary>no match</summary>
    <content>match</content>
</item>
XML
);

        $this->assertEquals('match', $entry->getContent());
    }

    /** @test */
    public function description_can_be_parsed(): void
    {
        $entry = $this->factory->create(
            <<<XML
<item>
    <title>A</title>
    <summary>no match</summary>
    <description>match</description>
</item>
XML
);

        $this->assertEquals('match', $entry->getContent());
    }

    /** @test */
    public function summary_can_be_parsed(): void
    {
        $entry = $this->factory->create(
            <<<XML
<item>
    <title>A</title>
    <summary>match</summary>
</item>
XML
);

        $this->assertEquals('match', $entry->getContent());
    }

    /** @test */
    public function tags_can_be_parsed(): void
    {
        foreach (Tag::all() as $tag) {
            $keyword = collect($tag->keywords)->random();

            $entry = $this->factory->create(
                <<<XML
<item>
    <title>A</title>
    <summary>${keyword} ${keyword}</summary>
</item>
XML
            );

            $this->assertEquals([$tag->id], $entry->tags()->toArray());
        }
    }

    /** @test */
    public function tags_from_categories(): void
    {
        $entry = $this->factory->create(
            <<<XML
<item>
    <title>A</title>
    <summary>A</summary>
    <category><![CDATA[javascript]]></category>
    <category>php</category>
</item>
XML
        );

        $javascript = Tag::whereName('javascript')->first();

        $php = Tag::whereName('php')->first();

        $tags = $entry->tags();

        $this->assertEquals([$php->id, $javascript->id], $tags->values()->toArray());
    }
}
