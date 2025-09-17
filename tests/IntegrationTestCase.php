<?php

declare(strict_types=1);

namespace Tests;

use Tempest\Framework\Testing\IntegrationTest;

abstract class IntegrationTestCase extends IntegrationTest
{
    protected string $root = __DIR__ . '/../';
}
