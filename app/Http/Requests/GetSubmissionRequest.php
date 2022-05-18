<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isDoctor() || $this->isPatientSubmission();
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
        $submissionIsPending = $this->submission['status'] === Submission::STATUS_PENDING;
        $submissionIsFromDoctor = $this->submission['doctor_id'] === Auth::id();

        return Auth::user()->hasRole('doctor') && ($submissionIsPending || $submissionIsFromDoctor);
    }

    private function isPatientSubmission(): bool
    {
        return Auth::user()->hasRole('patient') && $this->submission['patient_id'] == Auth::user()->id;
    }
}
