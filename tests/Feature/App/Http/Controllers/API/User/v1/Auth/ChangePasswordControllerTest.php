<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use App\Enums\Guard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ChangePasswordController.
 *
 * @requires PHP >= 7.2
 *
 * @covers \ChangePasswordController
 */

/**
 * @internal
 * @covers \App\Http\Controllers\API\User\v1\Auth\ChangePasswordController::_invoke
 */
final class ChangePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testInvoke.
     *
     * @return array
     */
    public function providerInvokeWithAllEmptyValues(): array
    {
        return [
            ['old_password' => null],
            ['new_password' => ''],
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ChangePasswordController::_invoke
     */
    public function testChangePassword(): void
    {
        $arrUserData = TestCase::createUser(GUARD::USER);

        $resultLogin = TestCase::executeUserLogin($arrUserData);

        // Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/changepsw',
            ['old_password' => \auth(GUARD::USER)->user()->password, 'new_password' => $this->objFaker->password],
            ['Authorization' => \json_decode($resultLogin->getContent())->token,
                'Content-Type' => 'application/json', ]
        );

        $resultLogin->assertOk();
    }
}
