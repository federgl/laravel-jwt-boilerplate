<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RedirectIfAuthenticatedTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class RedirectIfAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testHandle.
     *
     * @return array
     */
    public function providerHandle(): array
    {
    }

    /**
     * @covers \App\Http\Middleware\RedirectIfAuthenticated::handle
     */
    public function testHandle(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
