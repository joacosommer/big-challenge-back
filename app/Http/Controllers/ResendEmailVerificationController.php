<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResendEmailVerificationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your email address has already been verified.',
            ], 422);
        }
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email resent successfully.'], 200);
    }
}
