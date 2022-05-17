<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Http\Resources\PatientResource;
use App\Models\PatientInformation;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformation extends Controller
{
    public function __invoke(UpdatePatientInformationRequest $request): PatientResource
    {
        $patient = PatientInformation::where('user_id', Auth::user()['id'])->first();
        $patient->update($request->all());

        return (new PatientResource($patient))->additional(['meta' => [
            'message' => 'Successfully update patient information.',
            'status' => 200,
        ]]);
    }
}
