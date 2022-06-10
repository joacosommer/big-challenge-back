<?php

namespace App\Http\Requests;

use App\Models\Submission;
use App\Models\User;
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
        /** @var Submission $submission */
        $submission = $this->route('submission');
        /** @var User $user */
        $user = Auth::user();
        $submissionIsPending = $submission->status === Submission::STATUS_PENDING;
        $submissionIsFromDoctor = $submission->doctor_id === $user->id;

        return $user->hasRole('doctor') && ($submissionIsPending || $submissionIsFromDoctor);
    }

    private function isPatientSubmission(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');
        /** @var User $user */
        $user = Auth::user();
        return $user->hasRole('patient') && $submission->patient_id == $user->id;
    }
}
