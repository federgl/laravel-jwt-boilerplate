<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Enums\Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Post(
 *     path="/api/auth/user/login",
 *     operationId="authuserLogin",
 *     tags={"Security"},
 *     summary="Authenticates user using username and password",
 *     description="Authenticate user",
 *     @OA\Parameter(
 *         name="email",
 *         description="Email Address",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="password",
 *         description="Password",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="successful operation"
 *     ),
 *     @OA\Response(response=400, description="Bad request"),
 *     @OA\Response(response=422, description="Unprocessible Entity"),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 *
 * Authenticates a new user.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @param LoginRequest $objLoginRequest
     *
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $objLoginRequest): ?JsonResponse
    {
        /** @var \Tymon\JWTAuth\JWTGuard $objJWTGuard */
        $objJWTGuard = Auth::guard(GUARD::USER);

        $strToken = $objJWTGuard->attempt([
            'email' => $objLoginRequest->email,
            'password' => $objLoginRequest->password,
        ], true);
        if (false === $strToken) {
            $this->response->errorUnauthorized('Wrong username or password.');
            
            return null;
        }

        /** @var User $objUser */
        $objUser = $objJWTGuard->user();

        if (false === (bool) $objUser->account_verified) {
            $this->response->errorUnauthorized('Email verification not done.');

            return null;
        }

        Log::info('[INFO] - User: '. $objLoginRequest->email.' is now logged in.');

        return \response()->json([
            'token' => $strToken,
        ]);
    }
}
