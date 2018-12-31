<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\Guard;

/**
 * Class LogoutControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LogoutController::__invoke
     */
    public function testInvokeSuccessfulUserLogout(): string
    {
        $arrUser = TestCase::createUser(GUARD::USER);

        # Perform a logout operation
        $result = TestCase::executeUserLogout($arrUser);
       
        #Check for 200 OK status
        $result[0]->assertOk();

        #Return token used
        return $result[1];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LogoutController::__invoke
    */
    public function testInvokeAlreadyLoggedOutToken(): void
    {
        # Execute a successful logout
        $strToken = $this->testInvokeSuccessfulUserLogout();
        
        # Try to re logout same token
        $objResponse = $this->json(
                    'POST',
                    'api/auth/user/logout',
                    [],
                    ['Authorization' => 'Bearer '.$strToken]
        );

        $objResponse->assertStatus(401);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LogoutController::__invoke
    */
    public function testInvokeWithoutToken(): void
    {
        $objResponse = $this->json(
                    'POST',
                    'api/auth/user/logout',
                    [],
                    ['Authorization' => 'Bearer ']
        );

        $objResponse->assertStatus(401);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LogoutController::__invoke
    */
    public function testInvokeWithoutAuthParam(): void
    {
        $objResponse = $this->json(
                    'POST',
                    'api/auth/user/logout',
                    [],
                    []
        );

        $objResponse->assertStatus(401);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\LogoutController::__invoke
    */
    public function testInvokeIncorrectToken(): void
    {
        $objResponse = $this->json(
                    'POST',
                    'api/auth/user/logout',
                    [],
                    ['Authorization' => 'Bearer '.$this->objFaker->password]
        );

        $objResponse->assertStatus(401);
    }
}
