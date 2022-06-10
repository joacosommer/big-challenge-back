<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class DoctorTakeSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @mixin Submission
         * @var Submission $submission
         */
        $submission = $this->route('submission');

        return $this->submissionIsPending($submission);
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

    private function submissionIsPending(Submission $submission): bool
    {
        return $submission['status'] == Submission::STATUS_PENDING;
    }
}
