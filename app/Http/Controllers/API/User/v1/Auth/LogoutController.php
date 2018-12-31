<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Enums\Guard;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

/**
 * Class LogoutController.
 *
 * @OA\Post(
 *     path="/api/auth/user/logout",
 *     operationId="authuserLogout",
 *     tags={"Security"},
 *     summary="It allows user to invalidate its tokens so new login will be required",
 *     description="Logout user",
 *     @OA\Response(
 *         response=200,
 *         description="{'success': true}"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
class LogoutController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            \auth(GUARD::USER)->logout();
            return \response()->json(['success' => true]);
        } catch (JWTException $objException) {
            return \response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 401);
        }
    }
}
