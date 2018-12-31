<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

/**
 * Class ForgotPasswordController.
 *
 * @OA\Post(
 *     path="/api/auth/user/forgot/password/reset",
 *     operationId="authuserForgotPasswordReset",
 *     tags={"Security"},
 *     summary="It allows user to reset/change their passwords. ",
 *     description="Reset Password",
 *     @OA\Parameter(
 *         name="token",
 *         description="Token string received in email by user.",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
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
 *     @OA\Parameter(
 *         name="password_confirmation",
 *         description="Password confirmation string",
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
 *     @OA\Response(
 *         response=201,
 *         description="successful operation"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessible Entity"
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @param Request $objRequest
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(ResetPasswordRequest $objRequest)
    {
        Log::info('[INFO] - User: '. $objRequest->email.' starts resetting password.');

        $strResponse = $this->broker()->reset(
            $this->credentials($objRequest),
            function ($objUser, $strPassword): void {
                $this->resetPassword($objUser, $strPassword);
            }
        );

        switch ($strResponse) {
            case Password::PASSWORD_RESET:
                Log::info('[INFO] - User: '. $objRequest->email.' resets password successfully.');
                $objResponse = \response()->json(['message' => 'Password reset successfully.', 'status' => true], 201);
                break;
            default:
                Log::info('[INFO] - User: '. $objRequest->email.' unable to reset password.');
                $objResponse = \response()->json(['message' => 'Unable to reset password', 'status' => false], 401);
                break;
        }

        return $objResponse;
    }

    /**
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker('users');
    }
}
