<?php

namespace App\Listeners;

use App\Events\UploadPrescription;
use App\Notifications\PrescriptionUploadNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendDoctorPrescriptionNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UploadPrescription  $event
     * @return void
     */
    public function handle(UploadPrescription $event)
    {
        // @todo: url futura del frontend
        $url = env('APP_URL').':3000/login';
        Notification::route('mail', $event->submission->patient->email)->notify(new PrescriptionUploadNotification($url, $event->submission));
    }
}
