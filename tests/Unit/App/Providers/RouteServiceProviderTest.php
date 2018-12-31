<?php

declare(strict_types=1);

namespace Tests\Unit\App\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RouteServiceProviderTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class RouteServiceProviderTest extends TestCase
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
     * Data provider for testMap.
     *
     * @return array
     */
    public function providerMap(): array
    {
    }

    /**
     * Data provider for testMapApiRoutes.
     *
     * @return array
     */
    public function providerMapApiRoutes(): array
    {
    }

    /**
     * Data provider for testMapWebRoutes.
     *
     * @return array
     */
    public function providerMapWebRoutes(): array
    {
    }

    /**
     * @covers \App\Providers\RouteServiceProvider::boot
     */
    public function testBoot(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\RouteServiceProvider::map
     */
    public function testMap(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\RouteServiceProvider::mapApiRoutes
     */
    public function testMapApiRoutes(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\RouteServiceProvider::mapWebRoutes
     */
    public function testMapWebRoutes(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
