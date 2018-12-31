<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\Guard;

/**
 * Class LoginControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @covers LoginController
 */
final class LoginControllerTest extends TestCase
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
            ['email' => null],
            ['email' => ''],
            ['email' => '     ']
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     *
     */
    public function testInvokeSuccessfulLogin() : void
    {
        $arrUserData = TestCase::createUser(GUARD::USER);
        
        $resultLogin = TestCase::executeUserLogin($arrUserData);

        # Assert if response status is 200.
        $resultLogin->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     */
    public function testInvokeIncompleteEmailLogin(): void
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/login',
            ['password' => $arrUser[1]],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(422);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     */
    public function testInvokeIncompletePasswordLogin(): void
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/login',
            ['email' => $arrUser[0]],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(422);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     */
    public function testInvokeIncompleteLogin(): void
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/login',
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(422);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     */
    public function testInvokeIncorrectEmailLogin(): void
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/login',
            ['email' => $this->objFaker->email, 'password' => $arrUser[1]],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(401);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LoginController::_invoke
     */
    public function testInvokeIncorrectPasswordLogin(): void
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Check Login
        $objResponse = $this->json(
            'POST',
            'api/auth/user/login',
            ['email' => $arrUser[0], 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(401);
    }
}
