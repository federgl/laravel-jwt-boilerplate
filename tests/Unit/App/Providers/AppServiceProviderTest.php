<?php

declare(strict_types=1);

namespace Tests\Unit\App\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AppServiceProviderTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class AppServiceProviderTest extends TestCase
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
     * Data provider for testRegister.
     *
     * @return array
     */
    public function providerRegister(): array
    {
    }

    /**
     * @covers \App\Providers\AppServiceProvider::boot
     */
    public function testBoot(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\AppServiceProvider::register
     */
    public function testRegister(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
