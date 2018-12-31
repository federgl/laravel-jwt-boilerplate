<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\VerifyUser.
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VerifyUser whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class VerifyUser extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'token',
    ];

    protected $guarded = [];
    protected $table = 'verify_user';

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
