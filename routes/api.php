<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

use App\Enums\UserRole;

$api = app(\Dingo\Api\Routing\Router::class);

$api->version('v1', static function (Dingo\Api\Routing\Router $api): void {
    $api->group(['prefix' => 'auth'], static function ($api): void {
        $api->group(['prefix' => 'user'], static function ($api): void {
            $api->post('register', \App\Http\Controllers\API\User\v1\Auth\SignupController::class)->name('auth.user.register');
            $api->get('register/verify/{token}', \App\Http\Controllers\API\User\v1\Auth\EmailVerifyController::class)->name('auth.user.register.verify');
            $api->post('login', \App\Http\Controllers\API\User\v1\Auth\LoginController::class)->name('auth.user.login');
            $api->post('forgot/password', \App\Http\Controllers\API\User\v1\Auth\ForgotPasswordController::class)->name('auth.user.forgot.password');
            $api->post('forgot/password/reset', \App\Http\Controllers\API\User\v1\Auth\ResetPasswordController::class)->name('auth.user.forgot.password.reset');
            
            $api->group(['middleware' => ['auth:user', 'role:'.UserRole::USER]], static function ($api): void {
                $api->post('changepsw', \App\Http\Controllers\API\User\v1\Auth\ChangePasswordController::class)->name('auth.user.changepsw');
                $api->post('logout', \App\Http\Controllers\API\User\v1\Auth\LogoutController::class)->name('auth.user.logout');
            });
        });
    });
});
