<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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
    public function providerInvokeWithAllEmptyValues(): array
    {
        return [
            ['token' => null],
            ['token' => ''],
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox validates that email verify token can be used only once. Reattempting will show error.
     */
    public function testInvokeEmailVerificationTokenCanBeUsedOnlyOnce(): void
    {
        $strToken = $this->objFaker->sha256;

        $objUser = $this->prepareUser();
        $objUser->save();

        VerifyUser::create([
            'user_id' => $objUser->id,
            'token' => $strToken,
        ]);

        $this->get(
            'api/auth/user/register/verify/'.$strToken,
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse = $this->get(
            'api/auth/user/register/verify/'.$strToken,
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Your e-mail is already verified. You can now login.',
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox validates that token parameter is passed in request.
     */
    public function testInvokeValidateMissingTokenParameter(): void
    {
        $objResponse = $this->json(
            'GET',
            'api/auth/user/register/verify/'.'       ',
            [],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox generate error when invalid token as number is provided
     */
    public function testInvokeValidateTokenForNumericToken(): void
    {
        $objResponse = $this->json(
            'GET',
            'api/auth/user/register/verify/'.$this->objFaker->randomNumber(5),
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Sorry your email cannot be identified.',
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox generate error when invalid token is provided
     */
    public function testInvokeValidateValidTokenParameter(): void
    {
        $objResponse = $this->json(
            'GET',
            'api/auth/user/register/verify/'.$this->objFaker->sha256,
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Sorry your email cannot be identified.',
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox generate password reset email for existing user in system
     */
    public function testInvokeVerificationEmailRecordExists(): void
    {
        $objUser = $this->prepareUser();
        $objUser->save();

        $strToken = $this->objFaker->sha256;

        VerifyUser::create([
            'user_id' => $objUser->id,
            'token' => $strToken,
        ]);

        $objResponse = $this->get(
            'api/auth/user/register/verify/'.$strToken,
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Your e-mail is verified. You can now login.',
            ]);
    }

    /**
     * @dataProvider providerInvokeWithAllEmptyValues
     *
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox generate password reset email for existing user in system
     *
     * @param mixed $strToken
     */
    public function testInvokeWithAllEmptyValues($strToken): void
    {
        $objResponse = $this->get(
            'api/auth/user/register/verify/'.$strToken,
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(404)
            ->assertJsonFragment([
                'status_code' => 404,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::__invoke
     *
     * @testdox generate password reset email for existing user in system
     */
    public function testInvokeWithAllMissingParameters(): void
    {
        $objResponse = $this->get(
            'api/auth/user/register/verify/',
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(404)
            ->assertJsonFragment([
                'status_code' => 404,
            ]);
    }

    /**
     * @return \App\Models\User
     */
    private function prepareUser(): User
    {
        $strName = $this->objFaker->name;
        $strEmail = $this->objFaker->email;
        $strPassword = $this->objFaker->password;

        $objUser = new User([
            'name' => $strName,
            'email' => $strEmail,
            'password' => Hash::make($strPassword),
        ]);
        
        // @codingStandardsIgnoreLine
        $objUser->active = true;
        
        return $objUser;
    }
}
