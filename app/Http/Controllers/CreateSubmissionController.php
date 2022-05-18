<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreateSubmissionController extends Controller
{
    public function __invoke(CreateSubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $submission = Submission::create([
            'patient_id' => Auth::id(),
            'title' => $data['title'],
            'date_symptoms_start' => $data['date_symptoms_start'],
            'description' => $data['description'],
            'status' => Submission::STATUS_PENDING,
        ]);
        $submission->save();

        return response()->json([
            'message' => 'Submission created successfully',
        ], 201);
    }
}
