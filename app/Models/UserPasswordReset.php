<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPasswordReset.
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserPasswordReset whereToken($value)
 * @mixin \Eloquent
 */
class UserPasswordReset extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'email', 'token',
    ];

    protected $guard = 'user';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_password_resets';
}
