<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationController extends Controller
{
    public function __invoke(UpdateDoctorInformationRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->doctorInformation()->update($request->validated());

        return (new UserResource($user))->additional(['meta' => [
            'message' => 'Successfully update doctor information.',
            'status' => 200,
        ]]);
    }
}
