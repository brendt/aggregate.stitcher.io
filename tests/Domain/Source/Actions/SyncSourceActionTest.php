<?php

namespace Tests\Domain\Source\Actions;

use Domain\Post\Models\Post;
use Domain\Source\Actions\SyncSourceAction;
use Tests\Factories\SourceFactory;
use Tests\Mocks\MockReader;
use Tests\TestCase;

class SyncSourceActionTest extends TestCase
{
    /** @var \Domain\Source\Models\Source */
    private $source;

    protected function setUp()
    {
        parent::setUp();

        $this->source = SourceFactory::new()->create();
    }

    /** @test */
    public function it_creates_a_post()
    {
        $action = new SyncSourceAction(
            MockReader::new()->withPost()
        );

        $action->__invoke($this->source);

        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function it_wont_create_two_posts_for_the_same_source_on_the_same_day()
    {
        $action = new SyncSourceAction(
            MockReader::new()
                ->withPost('/a', [
                    'date' => '2019-01-01',
                ])
                ->withPost('/b', [
                    'date' => '2019-01-01',
                ])
        );

        $action->__invoke($this->source);

        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function it_will_create_two_posts_for_the_same_source_on_separate_days()
    {
        $action = new SyncSourceAction(
            MockReader::new()
                ->withPost('/a', [
                    'date' => '2019-01-01',
                ])
                ->withPost('/b', [
                    'date' => '2019-01-02',
                ])
        );

        $action->__invoke($this->source);

        $this->assertCount(2, Post::all());
    }

    /** @test */
    public function it_will_create_two_posts_for_separate_sources_on_the_same_day()
    {
        $otherSource = SourceFactory::new()
            ->withUrl('https://other.com')
            ->create();

        (new SyncSourceAction(
            MockReader::new()
                ->withPost('/a', [
                    'date' => '2019-01-01',
                ])
        ))->__invoke($this->source);

        (new SyncSourceAction(
            MockReader::new()
                ->withPost('/a', [
                    'date' => '2019-01-01',
                ])
        ))->__invoke($otherSource);

        $this->assertCount(2, Post::all());
    }
}
