<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ResetPasswordControllerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class ResetPasswordControllerTest extends TestCase
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
            ['token' => null, 'email' => null, 'password' => null],
            ['token' => '', 'email' => '', 'password' => ''],
            ['token' => '      ', 'email' => '       ', 'password' => '      '],
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox validates that reset password fails for wrong toke or email data.
     */
    public function testInvokePasswordResetFailsWithWrongData(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->objFaker->email,
                'password' => $this->objFaker->password,
            ],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Unable to reset password',
            ])
            ->assertJsonFragment([
                'status' => false,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox validates that token length should not be greater than 64 characters
     */
    public function testInvokeValidateDataLargerTokenForLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['token' => $this->objFaker->text(1000), 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token must be 64 characters.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox validates that token parameter missing in request body
     */
    public function testInvokeValidateDataMissingToken(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox validates that token length should not be smaller than 64 characters
     */
    public function testInvokeValidateDataSmallerTokenForLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['token' => $this->objFaker->randomLetter, 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token must be 64 characters.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::__invoke
     *
     * @testdox validates that token is in string format
     */
    public function testInvokeValidateDataTokenShouldBeString(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['token' => $this->objFaker->randomNumber(5), 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token must be 64 characters.', 'The token must be a string.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generates error when email address domain name in greater than 64 characters.
     */
    public function testInvokeValidateEmailDataDomainLengthInvalid(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->objFaker->userName.'@'.$this->generateText(64).'.'.$this->objFaker->tld,
                'password' => 'password123',
            ],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generates error when email address is not of type string
     */
    public function testInvokeValidateEmailDataMissingInvalidDataType(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->objFaker->randomNumber,
                'password' => $this->objFaker->password,
            ],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generates error when email address username is missing
     */
    public function testInvokeValidateEmailDataMissingUsername(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->objFaker->safeEmailDomain,
                'password' => $this->objFaker->password,
            ],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generates error when email address username in greater than 64 characters.
     */
    public function testInvokeValidateEmailDataUsernameLengthInvalid(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->generateText(65).'@'.$this->objFaker->freeEmailDomain,
                'password' => $this->objFaker->password,
            ],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generate warning when email field is not passed in request
     */
    public function testInvokeValidateEmailParameterNotMissing(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'password' => $this->objFaker->password,
            ],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox validates that password length is at least 6 characters
     */
    public function testInvokeValidatePasswordForLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['token' => $this->generateToken(), 'email' => $this->objFaker->email, 'password' => $this->objFaker->randomLetter],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password must be at least 6 characters.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generate warning when password datatype is not string
     */
    public function testInvokeValidatePasswordParameterDataTypeAsString(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            [
                'token' => $this->generateToken(),
                'email' => $this->objFaker->email,
                'password' => $this->objFaker->randomNumber(7, true),
            ],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password must be a string.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generate error when password parameter is not passed in request
     */
    public function testInvokeValidatePasswordParameterExists(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/forgot/password/reset',
            ['tone' => $this->generateToken(), 'email' => $this->objFaker->email],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox validates that all parameter values are null in request body
     *
     * @dataProvider providerInvokeWithAllEmptyValues
     *
     * @param null|mixed $strToken
     * @param null|mixed $strEmail
     * @param null|mixed $strPassword
     */
    public function testInvokeWithAllEmptyValues($strToken = null, $strEmail = null, $strPassword = null): void
    {
        $objResponse = $this->post(
            'api/auth/user/forgot/password/reset',
            ['token' => $strToken, 'email' => $strEmail, 'password' => $strPassword],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token field is required.'],
            ])
            ->assertJsonFragment([
                'email' => ['The email field is required.'],
            ])
            ->assertJsonFragment([
                'password' => ['The password field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::__invoke
     *
     * @testdox generates validation when all request parameter are missing
     */
    public function testInvokeWithAllMissingParameters(): void
    {
        $objResponse = $this->post(
            'api/auth/user/forgot/password/reset',
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'token' => ['The token field is required.'],
            ])
            ->assertJsonFragment([
                'email' => ['The email field is required.'],
            ])
            ->assertJsonFragment([
                'password' => ['The password field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @return string
     */
    private function generateToken(): string
    {
        return \hash_hmac('sha256', $this->objFaker->text(10), $this->objFaker->sha256);
    }
}
