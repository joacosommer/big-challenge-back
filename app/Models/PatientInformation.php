<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
