<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ListSubmissionController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $submissions = Auth::user()->patientSubmission();
        if (Auth::user()->hasRole('doctor')) {
            $submissions = Auth::user()->doctorSubmission()->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }
        if (Auth::user()->hasRole('patient')) {
            $submissions = Auth::user()->patientSubmission()->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }

        return SubmissionResource::collection($submissions->paginate(10));
    }
}
