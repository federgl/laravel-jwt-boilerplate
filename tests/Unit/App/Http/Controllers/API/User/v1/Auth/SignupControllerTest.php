<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class SignupControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class SignupControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testInvoke.
     *
     * @return array
     */
    public function providerInvoke(): array
    {
    }

    /**
     * Data provider for testPrepare.
     *
     * @return array
     */
    public function providerPrepare(): array
    {
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     */
    public function testInvoke(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::prepare
     */
    public function testPrepare(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
