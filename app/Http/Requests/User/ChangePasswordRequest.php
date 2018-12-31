<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Dingo\Api\Http\FormRequest;
use App\Enums\Guard;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChangePasswordRequest.
 */
class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (null === \auth(GUARD::USER)->user()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string']
        ];
    }
}
