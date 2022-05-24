<?php

namespace App\Listeners;

use App\Events\UploadPrescription;
use App\Notifications\PrescriptionUploadNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
        $fileName = $event->submission['file'];
        $folder = config('filesystems.disks.do.folder');
        $url = Storage::temporaryUrl(
            "{$folder}/{$fileName}",
            now()->addWeek()
        );
        Notification::route('mail', $event->submission->patient->email)->notify(new PrescriptionUploadNotification($url, $event->submission));
    }
}
