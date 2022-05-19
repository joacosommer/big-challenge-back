<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformation extends Controller
{
    public function __invoke(UpdatePatientInformationRequest $request): UserResource
    {
        Auth::user()->patientInformation()->update($request->validated());

        return (new UserResource(Auth::user()))->additional(['meta' => [
            'message' => 'Successfully update patient information.',
            'status' => 200,
        ]]);
    }
}
