<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DoctorInvitation
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\DoctorInvitationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInvitation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DoctorInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
    ];
}
