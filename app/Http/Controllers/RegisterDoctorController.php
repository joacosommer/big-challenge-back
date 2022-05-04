<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDoctorRequest;
use App\Models\DoctorInformation;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterDoctorController extends Controller
{
    public function __invoke(RegisterDoctorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($this->getUserData($data));
        DoctorInformation::create($this->getDoctorData($data, $user));
        $user->assignRole('doctor');

        return response()->json(['message' => 'Doctor registered successfully'], 201);
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

    private function getDoctorData(array $data, User $user): array
    {
        return [
            'specialty' => $data['specialty'],
            'bank_account_number' => $data['bank_account_number'],
            'user_id' => $user->id,
        ];
    }
}
