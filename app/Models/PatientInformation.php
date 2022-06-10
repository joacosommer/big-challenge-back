<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PatientInformation
 *
 * @property int $id
 * @property int $user_id
 * @property int $weight
 * @property int $height
 * @property string $insurance_provider
 * @property string|null $current_medications
 * @property string|null $allergies
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PatientInformationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereCurrentMedications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereInsuranceProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientInformation whereWeight($value)
 * @mixin \Eloquent
 */
class PatientInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'height',
        'insurance_provider',
        'current_medications',
        'allergies',
        'user_id',
    ];

    /**
     * @return BelongsTo<User, PatientInformation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
