<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

/**
 * Class UserTransformer.
 */
class UserTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param \App\Models\User $objUser
     *
     * @return array
     */
    public function transform(User $objUser): array
    {
        return [
            'id' => (int) $objUser->id,
            'name' => $objUser->name,
            'email' => $objUser->email,
        ];
    }
}
