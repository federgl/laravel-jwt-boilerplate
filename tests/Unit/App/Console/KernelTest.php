<?php

declare(strict_types=1);

namespace Tests\Unit\App\Console;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class KernelTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class KernelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testCommands.
     *
     * @return array
     */
    public function providerCommands(): array
    {
    }

    /**
     * Data provider for testSchedule.
     *
     * @return array
     */
    public function providerSchedule(): array
    {
    }

    /**
     * @covers \App\Console\Kernel::commands
     */
    public function testCommands(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Console\Kernel::schedule
     */
    public function testSchedule(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
