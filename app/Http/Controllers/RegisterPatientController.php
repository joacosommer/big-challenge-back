<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPatientRequest;
use App\Models\PatientInformation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterPatientController extends Controller
{
    public function __invoke(RegisterPatientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($this->getUserData($data));
        PatientInformation::create($this->getPatientData($data, $user));
        $user->assignRole('patient');

        event(new Registered($user));

        return response()->json(['message' => 'Patient registered successfully'], 201);
    }

    private function getUserData(array $data): array
    {
        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
    }

    private function getPatientData(array $data, User $user): array
    {
        return [
            'weight' => $data['weight'],
            'height' => $data['height'],
            'insurance_provider' => $data['insurance_provider'],
            'current_medications' => $data['current_medications'],
            'allergies' => $data['allergies'],
            'user_id' => $user->id,
        ];
    }
}
