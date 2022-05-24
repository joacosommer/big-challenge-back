<?php

namespace Tests\Feature;

use App\Events\UploadPrescription;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadedPrescriptionNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function uploaded_prescription_notification_is_sent_to_doctor()
    {
        Event::fake();
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($submission->doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        Event::assertDispatched(UploadPrescription::class);
    }
}
