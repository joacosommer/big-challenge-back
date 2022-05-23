<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DigitalOceanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');

        return $this->submissionIsFromDoctor($submission) && $this->submissionIsDone($submission);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'file', 'mimes:txt'],
        ];
    }

    public function submissionIsFromDoctor(Submission $submission): bool
    {
        return $submission['doctor_id'] == Auth::user()->id;
    }

    public function submissionIsDone(Submission $submission): bool
    {
        return $submission['status'] == Submission::STATUS_DONE;
    }
}
