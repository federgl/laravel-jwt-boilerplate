<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ForgotPasswordControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class ForgotPasswordControllerTest extends TestCase
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
            ['email' => '   '],
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox generate password reset email for existing user in system
     */
    public function testInvokeForgotPassword(): void
    {
        $strEmail = $this->objFaker->email;

        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $strEmail, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(201);

        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password',
            ['email' => $strEmail],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Reset link sent to your email.',
            ])
            ->assertJsonFragment([
                'status_code' => 200,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox generate validation error when email address is given with more than 64 characters for domain name
     */
    public function testInvokeValidateDataLargerDomainNameForEmailAddress(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password',
            ['email' => $this->objFaker->userName.'@'.$this->generateText(64).'.'.$this->objFaker->tld],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email must be a valid email address.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox generate validation error when email address is given as numeric data
     */
    public function testInvokeValidateDataNumericEmailAddress(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password',
            ['email' => $this->objFaker->randomNumber],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email must be a string.', 'The email must be a valid email address.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox generate validation error when email address is partially given
     */
    public function testInvokeValidateDataPartialEmailAddress(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password',
            ['email' => $this->objFaker->safeEmailDomain],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email must be a valid email address.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox generate validation error when non existent email address is provided to create forgot password request
     */
    public function testInvokeValidateNonExistentUserForgotPasswordRequest(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password',
            ['email' => $this->objFaker->email],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Email Address does not exists',
            ])
            ->assertJsonFragment([
                'status_code' => 401,
            ]);
    }

    /**
     * @dataProvider providerInvokeWithAllEmptyValues
     *
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox validates that email parameter value null in request body
     *
     * @param mixed $strToken
     */
    public function testInvokeWithAllEmptyValues($strToken): void
    {
        $objResponse = $this->post(
            'api/auth/user/forgot/password',
            ['email' => $strToken],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox validates that missing email parameter in request body
     */
    public function testInvokeWithAllMissingParameters(): void
    {
        $objResponse = $this->post(
            'api/auth/user/forgot/password',
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }
}
