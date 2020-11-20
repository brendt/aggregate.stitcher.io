<?php

namespace Tests\Domain\Spam;

use Domain\Source\Models\Source;
use Domain\Spam\Actions\SourceReportAction;
use Domain\User\Models\User;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /** @var User */
    private $user;

    /** @test */
    public function it_can_report_a_source(): void
    {
        /** @var Source $source */
        $source = factory(Source::class)->create();
        $report = 'Spam report';
        (new SourceReportAction())->__invoke($this->user, $source, $report);
        $this->user->refresh();
        $this->assertTrue($this->user->hasReported($source));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }
}
