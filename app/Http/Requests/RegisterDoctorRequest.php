<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDoctorRequest extends FormRequest
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
            'email' => ['required', 'email:strict', 'unique:users,email', 'exists:doctor_invitations,email,token,'.$this->token],
            'password' => ['required', 'string'],
            'specialty' => ['required', 'string'],
            'bank_account_number' => ['required', 'numeric'],
            'token' => ['required', 'string', 'exists:doctor_invitations,token'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            'token.exists' => 'The invitation token is invalid or has expired.',
        ];
    }
}
