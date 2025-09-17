<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 */
final class HomeControllerTest extends IntegrationTestCase
{
    #[Test]
    public function index_is_reachable(): void
    {
        $this->http
            ->get('/')
            ->assertOk()
            ->assertSee('Tempest');
    }
}
