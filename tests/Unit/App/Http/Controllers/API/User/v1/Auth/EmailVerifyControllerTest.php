<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class EmailVerifyControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class EmailVerifyControllerTest extends TestCase
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     */
    public function testInvoke(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
