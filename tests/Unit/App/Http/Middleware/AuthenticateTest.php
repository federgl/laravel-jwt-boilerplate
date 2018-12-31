<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AuthenticateTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testRedirectTo.
     *
     * @return array
     */
    public function providerRedirectTo(): array
    {
    }

    /**
     * @covers \App\Http\Middleware\Authenticate::redirectTo
     */
    public function testRedirectTo(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
