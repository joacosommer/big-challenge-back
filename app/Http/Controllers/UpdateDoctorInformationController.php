<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationController extends Controller
{
    public function __invoke(UpdateDoctorInformationRequest $request): UserResource
    {
        Auth::user()->doctorInformation()->update($request->validated());

        return (new UserResource(Auth::user()))->additional(['meta' => [
            'message' => 'Successfully update doctor information.',
            'status' => 200,
        ]]);
    }
}
