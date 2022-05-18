<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetDoctorInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        $doctor = Auth::user();

        return (new UserResource($doctor))->additional(['meta' => [
            'message' => 'Successfully retrieved doctor information.',
            'status' => 200,
        ]]);
    }
}
