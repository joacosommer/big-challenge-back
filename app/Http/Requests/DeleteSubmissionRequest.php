<?php

namespace App\Http\Requests;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isPatientSubmission() && $this->submissionIsPending();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    private function isPatientSubmission(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        /** @var Submission $submission */
        $submission = $this->route('submission');
        return $submission->patient_id == $user->id;
    }

    private function submissionIsPending(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');
        return $submission->status == Submission::STATUS_PENDING;
    }
}
