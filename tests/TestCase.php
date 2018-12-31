<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\Guard;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    /**
     * @var \Faker\Generator
     */
    protected $objFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->objFaker = \Faker\Factory::create();
    }

    /**
     * Data generator for a valid user.
     *
     * @param mixed $type
     *
     * @return array
     */
    public function createUser($type): array
    {
        // Generate Fake Data
        $strEmail = $this->objFaker->email;
        $strPwd = $this->objFaker->password;

        $this->createAndVerifyAccount(GUARD::USER, $strEmail, $strPwd);

        return [$strEmail, $strPwd];
    }

    /**
     * Login a valid user login.
     *
     * @param mixed $arrUserData
     */
    public function executeUserLogin($arrUserData): object
    {
        // Check login
        return $this->json(
            'POST',
            'api/auth/user/login',
            ['email' => $arrUserData[0], 'password' => $arrUserData[1]],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );
    }

    /**
     * Successful logout execution.
     *
     * @param mixed $arrUserData
     */
    public function executeUserLogout($arrUserData): array
    {
        // Log user into the platform to get a valid token on the response
        $objUser = $this->json(
            'POST',
            'api/auth/user/login',
            ['email' => $arrUserData[0], 'password' => $arrUserData[1]],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        // Token decode
        $strToken = \json_decode($objUser->getContent())->token;

        // Check logout
        $objResponse = $this->json(
                    'POST',
                    'api/auth/user/logout',
                    [],
                    ['Authorization' => 'Bearer '.$strToken]
        );

        return [$objResponse, $strToken];
    }

    /**
     * Create user account and activate it.
     *
     * @param mixed $userType
     * @param mixed $strEmail
     * @param mixed $strPwd
     */
    protected function createAndVerifyAccount($userType, $strEmail, $strPwd): void
    {
        // Create user
        $objCreateUser = $this->json(
            'POST',
            'api/auth/'.$userType.'/register',
            ['name' => $this->objFaker->name, 'email' => $strEmail, 'password' => $strPwd],
            ['Accept' => 'application/json', 'Content-Type' => 'application/json']
        );

        $objCreateUser->assertStatus(201);

        $classUser = \ucfirst($userType);
        $objCreateUser = User::where('email', $strEmail)->first();
        // Check if register token is valid and retrieve it
        $objVerifyAccount = VerifyUser::where('user_id', $objCreateUser->id)->first();

        $strToken = $objVerifyAccount->token;

        // Verify user account to be able to login
        $objResponse = $this->json(
                'GET',
                'api/auth/'.$userType.'/register/verify/'.$strToken,
                ['Accept' => 'application/json', 'Content-Type' => 'application/json']
            );
    }

    /**
     * @param mixed $intLength
     *
     * @return string
     */
    protected function generateText($intLength): string
    {
        $strText = \str_replace([' ', '.'], '', $this->objFaker->text($intLength + 100));

        return \mb_substr($strText, 0, $intLength);
    }
}
