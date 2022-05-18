<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isDoctor() || $this->isPatient();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    private function isDoctor(): bool
    {
        return Auth::user()->hasRole('doctor');
    }

    private function isPatient(): bool
    {
        return Auth::user()->hasRole('patient') && $this->submission['patient_id'] == Auth::user()->id;
    }
}
