<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DoctorInformation
 *
 * @property int $id
 * @property int $user_id
 * @property string $specialty
 * @property int|null $bank_account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DoctorInformationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereSpecialty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorInformation whereUserId($value)
 * @mixin \Eloquent
 */
class DoctorInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialty',
        'bank_account_number',
        'user_id',
    ];

    /**
     * @return BelongsTo<User, DoctorInformation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
