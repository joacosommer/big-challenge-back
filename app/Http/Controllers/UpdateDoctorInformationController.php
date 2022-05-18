<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Http\Resources\DoctorResource;
use App\Models\DoctorInformation;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationController extends Controller
{
    public function __invoke(UpdateDoctorInformationRequest $request)
    {
        $doctor = DoctorInformation::where('user_id', Auth::user()['id'])->first();
        $doctor->update($request->all());

        return (new DoctorResource($doctor))->additional(['meta' => [
            'message' => 'Successfully update doctor information.',
            'status' => 200,
        ]]);
    }
}
