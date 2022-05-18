<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Http\Resources\PatientResource;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformation extends Controller
{
    public function __invoke(UpdatePatientInformationRequest $request): PatientResource
    {
        Auth::user()->patientInformation()->update($request->all());

        return (new PatientResource(Auth::user()))->additional(['meta' => [
            'message' => 'Successfully update patient information.',
            'status' => 200,
        ]]);
    }
}
