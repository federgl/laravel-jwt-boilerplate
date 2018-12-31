<?php

declare(strict_types=1);

namespace Tests\Unit\App\Exceptions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class HandlerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class HandlerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testRender.
     *
     * @return array
     */
    public function providerRender(): array
    {
    }

    /**
     * Data provider for testReport.
     *
     * @return array
     */
    public function providerReport(): array
    {
    }

    /**
     * @covers \App\Exceptions\Handler::render
     */
    public function testRender(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Exceptions\Handler::report
     */
    public function testReport(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
