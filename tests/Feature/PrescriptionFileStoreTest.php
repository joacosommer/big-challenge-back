<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PrescriptionFileStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function doctor_can_upload_prescription_file()
    {
        $this->withoutExceptionHandling();
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($submission->doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertStatus(200);
        Storage::assertExists('joaquinsommer/'.$response->json('data')['file']);
    }

    /** @test */
    public function test_guest_cannot_upload_prescription_file()
    {
        $submission = Submission::factory()->inProgress()->create();
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function test_doctor_cannot_upload_prescription_file_for_submission_that_is_not_in_progress()
    {
        $submission = Submission::factory()->done()->create();
        $this->actingAs($submission->doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function test_doctor_cannot_upload_prescription_file_for_submission_that_is_not_from_him()
    {
        $submission = Submission::factory()->inProgress()->create();
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function test_doctor_cannot_upload_prescription_file_for_submission_that_does_not_exist()
    {
        $this->actingAs(User::factory()->doctor()->create());
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'. 999, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertNotFound();
    }

    /** @test */
    public function test_patient_cannot_upload_prescription_file()
    {
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($submission->patient);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
    }

    /** @test */
    public function test_file_must_be_a_file()
    {
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($submission->doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => 'not a file',
        ]);
        $response->assertUnprocessable();
    }

    /** @test */
    public function test_file_must_be_txt()
    {
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($submission->doctor);
        Storage::fake();
        $response = $this->postJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.pdf'),
        ]);
        $response->assertUnprocessable();
    }
}
