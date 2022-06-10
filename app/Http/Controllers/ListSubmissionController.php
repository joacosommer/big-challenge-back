<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ListSubmissionController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $submissions = $user->patientSubmission();
        if ($user->hasRole('doctor')) {
            $submissions = $user->doctorSubmission()->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }
        if ($user->hasRole('patient')) {
            $submissions = $user->patientSubmission()->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }

        return SubmissionResource::collection($submissions->paginate(10));
    }
}
