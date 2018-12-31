<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordController.
 *
 * @OA\Post(
 *     path="/api/auth/user/forgot/password",
 *     operationId="authuserForgotPassword",
 *     tags={"Security"},
 *     summary="User can request to reset their passwords.",
 *     description="User Forgot Password",
 *     @OA\Parameter(
 *         name="email",
 *         description="Email Address",
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
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @param Request $objRequest
     *
     * @return JsonResponse
     */
    public function __invoke(ForgotPasswordRequest $objRequest): JsonResponse
    {
        $strResponse = $this->broker()->sendResetLink($objRequest->only('email'));

        Log::info('[INFO] - User: '. $objRequest->only('email')['email'].' forgots the account password.');

        switch ($strResponse) {
            case Password::INVALID_USER:
                $objResponse = \response()->json(['message' => 'Email Address does not exists', 'status_code' => 401], 401);
                break;
            case Password::RESET_LINK_SENT:
                $objResponse = \response()->json(['message' => 'Reset link sent to your email.', 'status_code' => 200], 200);
                break;
            default:
                $objResponse = \response()->json(['message' => 'Unable to send reset link', 'status_code' => 401], 401);
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
