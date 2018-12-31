<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\API\User\v1\Auth;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
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
    public function providerInvokeWithAllEmptyValues(): array
    {
        return [
            ['name' => null, 'email' => null, 'password' => null],
            ['name' => '', 'email' => '', 'password' => ''],
            ['name' => '      ', 'email' => '       ', 'password' => '      '],
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox registers a new user in system.
     */
    public function testInvokeRegistration(): void
    {
        $strEmail = $this->objFaker->email;

        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $strEmail, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(201);

        $objUser = User::where('email', $strEmail)->first();
        static::assertInstanceOf(User::class, $objUser);

        $this->assertTrue($objUser->hasRole(UserRole::USER));
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that email address is of string type
     */
    public function testInvokeValidateEmailAddressShouldBeString(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $this->objFaker->randomNumber, 'password' => $this->objFaker->password],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that email format is valid
     */
    public function testInvokeValidateEmailFormat(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $this->objFaker->safeEmailDomain, 'password' => $this->objFaker->password],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox Validates that email address parameter is required in request
     */
    public function testInvokeValidateEmailParameterRequired(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'password' => $this->objFaker->password],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox generates error when email address is provided with user name with invalid length
     */
    public function testInvokeValidateEmailWithInvalidUserNameLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            [
                'name' => $this->objFaker->name,
                'email' => $this->generateText(65).'@'.$this->objFaker->freeEmailDomain,
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that name parameter is not missing in parameter
     */
    public function testInvokeValidateNameParameterIsNotMissing(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that name is of data type string
     */
    public function testInvokeValidateNameParameterIsString(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->randomNumber(5), 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name must be a string.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that name parameter length not grater than 256
     */
    public function testInvokeValidateNameParameterLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->text(1000), 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name may not be greater than 255 characters.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdoxvalidates that name parameter length not smaller than 2
     */
    public function testInvokeValidateNameParameterLengthNotShorterThanSpecifiedLimit(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->randomLetter, 'email' => $this->objFaker->email, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name must be at least 2 characters.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that password field is of type string
     */
    public function testInvokeValidatePasswordParameterIsOfTypeString(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $this->objFaker->email, 'password' => $this->objFaker->randomNumber(7)],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that password field is provided in request
     */
    public function testInvokeValidatePasswordParameterIsRequired(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $this->objFaker->email],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validates that password length is at least 6 characters
     */
    public function testInvokeValidatePasswordParameterLength(): void
    {
        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $this->objFaker->email, 'password' => $this->objFaker->randomLetter],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox validate that
     */
    public function testInvokeValidateSameEmailAddressCanNotBeReusedAgain(): void
    {
        $strName = $this->objFaker->name;
        $strEmail = $this->objFaker->email;
        $strPassword = $this->objFaker->password;

        $objUser = $this->prepareUser($strName, $strEmail, $strPassword);
        $objUser->save();

        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $strName, 'email' => $strEmail, 'password' => $strPassword],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email has already been taken.'],
            ])
            ->assertJsonFragment([
                'status_code' => 422,
            ]);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox register a user and validates that email verification record exists
     */
    public function testInvokeVerificationEmailRecordExists(): void
    {
        $strEmail = $this->objFaker->email;

        $objResponse = $this->json(
            'POST',
            'api/auth/user/register',
            ['name' => $this->objFaker->name, 'email' => $strEmail, 'password' => $this->objFaker->password],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse->assertStatus(201);

        $objUser = User::where('email', $strEmail)->first();
        static::assertInstanceOf(User::class, $objUser);

        $objVerifyUser = VerifyUser::where('user_id', $objUser->id)
            ->whereDate('created_at', Carbon::today())
            ->first();
        static::assertInstanceOf(VerifyUser::class, $objVerifyUser);
    }

    /**
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @dataProvider providerInvokeWithAllEmptyValues
     *
     * @param null|mixed $strName
     * @param null|mixed $strEmail
     * @param null|mixed $strPassword
     */
    public function testInvokeWithAllEmptyValues($strName = null, $strEmail = null, $strPassword = null): void
    {
        $objResponse = $this->post(
            'api/auth/user/register',
            ['name' => $strName, 'email' => $strEmail, 'password' => $strPassword],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
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
     * @covers \App\Http\Controllers\API\User\v1\Auth\SignupController::__invoke
     *
     * @testdox generate error when all of the request parameters are missing in request body.
     */
    public function testInvokeWithAllMissingParameters(): void
    {
        $objResponse = $this->post(
            'api/auth/user/register',
            [],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
        $objResponse
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
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
     * @param string[] $arrstrData
     * @param mixed $strName
     * @param mixed $strEmail
     * @param mixed $strPassword
     *
     * @return \App\Models\User
     */
    private function prepareUser($strName, $strEmail, $strPassword): User
    {
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
