<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Dingo\Api\Http\FormRequest;

/**
 * Class ResetPasswordRequest.
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => 'required|size:64|string',
            'email' => 'required|email|string',
            'password' => 'required|string|min:6',
        ];
    }
}
