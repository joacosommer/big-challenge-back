<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetSubmissionController extends Controller
{
    public function __invoke(Request $request, $id): SubmissionResource
    {
        if (Auth::user()->hasRole('patient')) {
            $submission = Submission::where('id', $id)->where('patient_id', Auth::user()->id)->first();
        } else {
            $submission = Submission::where('id', $id)->first();
        }

        return (new SubmissionResource($submission))->additional(['meta' => [
            'message' => 'Successfully update doctor information.',
            'status' => 200,
        ]]);
    }
}
