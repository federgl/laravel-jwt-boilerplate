<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Dingo\Api\Http\FormRequest;

/**
 * Class EmailVerifyRequest.
 */
class EmailVerifyRequest extends FormRequest
{
    /**
     * @param string[]|null $keys
     * @param null|mixed $arrstrKeys
     *
     * @return array
     */
    public function all($arrstrKeys = null): ?array
    {
        $arrstrResults = parent::all($arrstrKeys);

        $arrstrResults['token'] = \trim($this->route('token'));

        return $arrstrResults;
    }

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
            'token' => ['required', 'string', 'min:1'],
        ];
    }
}
