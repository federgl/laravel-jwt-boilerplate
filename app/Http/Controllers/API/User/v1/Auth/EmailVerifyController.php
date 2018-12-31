<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailVerifyRequest;
use App\Enums\Guard;
use App\Models\VerifyUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * After registering on site user receives email verification.
 * In that email there is link with token.
 * When user clicks on link, this API controller get invoked.
 *
 * @OA\Get(
 *     path="/api/auth/user/register/verify/{token}",
 *     operationId="authuserLogin",
 *     tags={"Security"},
 *     summary="verifies user email address and verified on",
 *     description="email  verification",
 *     @OA\Parameter(
 *         name="token",
 *         description="Encrypted Token",
 *         required=true,
 *         in="path",
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
 */
class EmailVerifyController extends Controller
{
    /**
     * @param string $strToken verification email token
     *
     * @return JsonResponse|null
     */
    public function __invoke(EmailVerifyRequest $objRequest): ?JsonResponse
    {
        $objVerifyUser = VerifyUser::where('token', $objRequest->token)->first();

        if (null === $objVerifyUser) {
            Log::info('[INFO] - Email: '. \auth(GUARD::USER)->user()['email'].' not existent on system.');
            $this->response->error('Sorry your email cannot be identified.', 422);

            return null;
        }

        /** @var \App\Models\User $objUser */
        $objUser = $objVerifyUser->user;

        $strStatus = 'Your e-mail is already verified. You can now login.';
        if (false === (bool) $objUser->account_verified) {
            $objUser->account_verified = true;
            $objUser->save();
            $strStatus = 'Your e-mail is verified. You can now login.';
        }
        Log::info('[INFO] - User: '. \auth(GUARD::USER)->user()['email'].' has activated the account successfully.');

        return \response()->json(['message' => $strStatus]);
    }
}
