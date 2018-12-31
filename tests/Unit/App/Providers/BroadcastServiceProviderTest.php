<?php

declare(strict_types=1);

namespace Tests\Unit\App\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BroadcastServiceProviderTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class BroadcastServiceProviderTest extends TestCase
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
     * @covers \App\Providers\BroadcastServiceProvider::boot
     */
    public function testBoot(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
