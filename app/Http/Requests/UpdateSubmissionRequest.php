<?php

namespace App\Http\Requests;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isSubmissionFromUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'date_symptoms_start' => ['required', 'date'],
            'description' => ['required', 'string'],
        ];
    }

    private function isSubmissionFromUser(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');
        /** @var User $user */
        $user = Auth::user();
        return $submission->patient_id == $user->id;
    }
}
