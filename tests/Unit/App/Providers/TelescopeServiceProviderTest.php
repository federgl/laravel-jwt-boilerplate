<?php

declare(strict_types=1);

namespace Tests\Unit\App\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class TelescopeServiceProviderTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class TelescopeServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testGate.
     *
     * @return array
     */
    public function providerGate(): array
    {
    }

    /**
     * Data provider for testHideSensitiveRequestDetails.
     *
     * @return array
     */
    public function providerHideSensitiveRequestDetails(): array
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
     * @covers \App\Providers\TelescopeServiceProvider::gate
     */
    public function testGate(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\TelescopeServiceProvider::hideSensitiveRequestDetails
     */
    public function testHideSensitiveRequestDetails(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Providers\TelescopeServiceProvider::register
     */
    public function testRegister(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
