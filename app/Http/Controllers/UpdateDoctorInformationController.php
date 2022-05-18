<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Http\Resources\DoctorResource;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationController extends Controller
{
    public function __invoke(UpdateDoctorInformationRequest $request): DoctorResource
    {
        Auth::user()->doctorInformation()->update($request->all());

        return (new DoctorResource(Auth::user()))->additional(['meta' => [
            'message' => 'Successfully update doctor information.',
            'status' => 200,
        ]]);
    }
}
