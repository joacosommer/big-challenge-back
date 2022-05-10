<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email:strict', 'unique:users,email'],
            'password' => ['required', 'string'],
            'weight' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'insurance_provider' => ['required', 'string'],
            'current_medications' => ['string', 'nullable'],
            'allergies' => ['string', 'nullable'],
        ];
    }
}
