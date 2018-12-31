<?php

declare(strict_types=1);

namespace Tests\Unit\App\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AuthServiceProviderTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class AuthServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testBoot.
     *
     * @return array
     */
    public function providerBoot(): array
    {
    }

    /**
     * @covers \App\Providers\AuthServiceProvider::boot
     */
    public function testBoot(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
