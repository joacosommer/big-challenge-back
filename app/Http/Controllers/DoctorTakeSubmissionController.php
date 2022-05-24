<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorTakeSubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DoctorTakeSubmissionController
{
    public function __invoke(DoctorTakeSubmissionRequest $request, Submission $submission): SubmissionResource
    {
        $submission->update([
            'doctor_id' => Auth::user()->id,
            'status' => Submission::STATUS_IN_PROGRESS,
        ]);

        return (new SubmissionResource($submission))->additional([
            'message' => 'Successfully take submission.',
            'status' => 200,
        ]);
    }
}
