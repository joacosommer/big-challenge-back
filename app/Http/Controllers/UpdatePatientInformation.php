<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePatientInformationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdatePatientInformation extends Controller
{
    public function __invoke(UpdatePatientInformationRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->patientInformation()->update($request->validated());

        return (new UserResource(Auth::user()))->additional(['meta' => [
            'message' => 'Successfully update patient information.',
            'status' => 200,
        ]]);
    }
}
