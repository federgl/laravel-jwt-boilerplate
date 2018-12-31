<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User\v1\Auth;

use App\Enums\Guard;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignupRequest;
use App\Mail\VerifyUserMail;
use App\Models\User;
use App\Models\VerifyUser;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Post(
 *     path="/api/auth/user/register",
 *     operationId="authuserRegister",
 *     tags={"Security"},
 *     summary="Register a new user in the system.",
 *     description="user registration",
 *     @OA\Parameter(
 *         name="name",
 *         description="user Name",
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
 *
 * Registers a new user.
 */
class SignupController extends Controller
{
    use ThrottlesLogins;

    /**
     * @param SignupRequest $objRequest
     *
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke(SignupRequest $objRequest): ?Response
    {
        $objUser = $this->prepare($objRequest->all());
        $objUser->assignRole(Role::findByName(UserRole::USER, GUARD::USER));
        
        DB::beginTransaction();
        
        try {
            $objUser->save();
            
            VerifyUser::create([
                'user_id' => $objUser->id,
                'token' => \str_random(40),
            ]);
            Log::info('[INFO] - New user created. Email: '. $objUser->email);
        } catch (\Exception $objException) {
            Log::info('[INFO] - New account creation failed. Email: '. $objUser->email);
            DB::rollBack();
            $this->response->error($objException->getMessage(), 422);

            return null;
        }

        DB::commit();

        Mail::to($objUser->email)->send(new VerifyUserMail($objUser));

        return $this->response->created();
    }

    /**
     * @param string[] $arrstrData
     *
     * @return \App\Models\User
     */
    public function prepare($arrstrData): User
    {
        $objUser = new User([
            'name' => $arrstrData['name'],
            'email' => $arrstrData['email'],
            'password' => Hash::make($arrstrData['password']),
        ]);
        // @codingStandardsIgnoreLine
        $objUser->active = true;

        return $objUser;
    }
}
