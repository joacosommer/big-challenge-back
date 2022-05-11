<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetPatientInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        $patient = Auth::user();

        return (new UserResource($patient))->additional(['meta' => [
            'message' => 'Successfully retrieved patient information.',
            'status' => 200,
        ]]);
    }
}
