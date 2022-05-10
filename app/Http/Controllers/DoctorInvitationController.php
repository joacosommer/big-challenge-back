<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorInvitationRequest;
use App\Models\DoctorInvitation;
use App\Notifications\DoctorInvitationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class DoctorInvitationController extends Controller
{
    public function __invoke(DoctorInvitationRequest $request): JsonResponse
    {
        $email = $request->input('email');
        do {
            $token = Str::random(20);
        } while (DoctorInvitation::where('token', $token)->first());
        DoctorInvitation::create([
            'email' => $email,
            'token' => $token,
        ]);
        $url = env('APP_URL') . ':3000/register/doctor'; //url futura del frontend
        Notification::route('mail', $email)->notify(new DoctorInvitationNotification($url, $token));

        return response()->json([
            'message' => 'Invitation sent successfully',
        ]);
    }
}
