<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListPendingSubmissionController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $submissions = Submission::where('status', Submission::STATUS_PENDING)->orderBy('created_at', 'desc');

        return SubmissionResource::collection($submissions->paginate(10));
    }
}
