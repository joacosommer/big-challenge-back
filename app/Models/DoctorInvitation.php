<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
    ];
}