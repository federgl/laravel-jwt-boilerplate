<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Dingo\Api\Http\FormRequest;

/**
 * Class ForgotPasswordRequest.
 */
class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|string',
        ];
    }
}
