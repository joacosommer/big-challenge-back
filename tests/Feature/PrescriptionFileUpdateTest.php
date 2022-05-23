<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PrescriptionFileUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function doctor_can_update_prescription_file()
    {
        $this->withoutExceptionHandling();
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->done()->create([
            'file' => $fileName,
        ]);
        $this->actingAs($submission->doctor);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_guest_cannot_update_prescription_file()
    {
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->done()->create([
            'file' => $fileName,
        ]);
        Storage::assertExists('joaquinsommer/'.$fileName);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function test_doctor_cannot_update_prescription_file_with_invalid_file()
    {
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->done()->create([
            'file' => $fileName,
        ]);
        $this->actingAs($submission->doctor);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => 'invalid',
        ]);
        $response->assertUnprocessable();
    }

    /** @test */
    public function test_doctor_cannot_update_prescription_file_that_is_not_from_him()
    {
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->done()->create([
            'file' => $fileName,
        ]);
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        Storage::assertExists('joaquinsommer/'.$fileName);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }

    /** @test */
    public function test_doctor_cannot_update_prescription_file_that_is_not_done()
    {
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->inProgress()->create([
            'file' => $fileName,
        ]);
        $this->actingAs($submission->doctor);
        Storage::assertExists('joaquinsommer/'.$fileName);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }

    /** @test */
    public function test_patient_cannot_update_prescription_file()
    {
        Storage::fake();
        Http::fake();
        $file = UploadedFile::fake()->create('test.txt');
        $fileName = (string) Str::uuid();
        Storage::put(
            'joaquinsommer/'.$fileName,
            file_get_contents($file),
        );
        $submission = Submission::factory()->done()->create([
            'file' => $fileName,
        ]);
        $this->actingAs($submission->patient);
        Storage::assertExists('joaquinsommer/'.$fileName);
        $response = $this->putJson('api/doctor/prescription/'.$submission->id, [
            'file' => UploadedFile::fake()->create('prescription.txt'),
        ]);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }
}
