<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResendEmailVerificationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your email address has already been verified.',
            ], 422);
        }
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email resent successfully.'], 200);
    }
}
