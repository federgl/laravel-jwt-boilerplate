<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Enums\Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Available when the user is already logged in.
 * Will be requested to write the actual password to set a new one.
 *
 * @OA\Post(
 *     path="/api/auth/user/changepsw",
 *     operationId="authuserLogin",
 *     tags={"Security"},
 *     summary="Allows the user to change their password from inside the site.",
 *     description="Password change",
 *     @OA\Parameter(
 *         name="token",
 *         description="Encrypted Token",
 *         required=true,
 *         in="path",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="old_password",
 *         description="Old Password",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="new_password",
 *         description="New Password",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(response=401, description="Token is not present or not valid"),
 *     @OA\Response(response=422, description="Old password is invalid"),
 *     @OA\Response(response=500, description="An error ocurred while updating the password"),
 *     @OA\Response(response=200, description="Password updated successfully"),
 *
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */


class ChangePasswordController extends Controller
{
    /**
     * @param ChangePasswordRequest $objRequest
     *
     * @return JsonResponse
     */
    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $objJWTGuard = Auth::guard('user');

            Log::info('[INFO] - User: '. \auth(GUARD::USER)->user()->email.' is requesting a password change.');

            // Check if provided password is correct
            $strCheckLogin = $objJWTGuard->validate([
                'email' => \auth(GUARD::USER)->user()->email,
                'password' => $request->input('old_password'),
            ], true);

            // Update password
            if ($strCheckLogin) {
                $objUser = User::find(\auth(GUARD::USER)->user()->id);
                $objUser->password = Hash::make($request->input('new_password'));
                $objUser->save();
            } else {
                Log::info('[INFO] - User: '. \auth(GUARD::USER)->user()->email.' password change failed.');
                return \response()->json(['message' => 'Old password is invalid'], 422);
            }
        } catch (\Exception $e) {
            Log::info('[INFO] - User: '. \auth(GUARD::USER)->user()->email.' password change failed.');
            return \response()->json(['message' => 'An error ocurred while updating the password'], 400);
        }

        Log::info('[INFO] - User: '. \auth(GUARD::USER)->user()->email.' has changed the password successfully.');
        return \response()->json(['message' => 'Password updated successfully'], 200);
    }
}
