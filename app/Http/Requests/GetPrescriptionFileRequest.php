<?php

namespace App\Http\Requests;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetPrescriptionFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');

        return ($this->submissionIsFromPatient($submission) || $this->submissionIsFromDoctor($submission)) && $this->submissionIsDone($submission);
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

    private function submissionIsFromPatient(Submission $submission): bool
    {
        /** @var User $user */
        $user = Auth::user();
        return $submission['patient_id'] === $user->id;
    }

    private function submissionIsDone(Submission $submission): bool
    {
        return $submission['status'] === Submission::STATUS_DONE;
    }

    private function submissionIsFromDoctor(Submission $submission): bool
    {
        /** @var User $user */
        $user = Auth::user();
        return $submission['doctor_id'] === $user->id;
    }
}
