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

class PrescriptionFileDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function doctor_can_delete_prescription_file()
    {
        $this->markTestSkipped('This test is skipped because...');
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
        $response = $this->deleteJson('api/doctor/prescription/'.$submission->id);
        $response->assertStatus(200);
        Storage::assertMissing('joaquinsommer/'.$fileName);
        $response->assertJson([
            'data' => [
                'file' => null,
                'status' => Submission::STATUS_IN_PROGRESS,
            ],
        ]);
    }

    /** @test */
    public function test_guest_cannot_delete_prescription_file()
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
        $response = $this->deleteJson('api/doctor/prescription/'.$submission->id);
        $response->assertUnauthorized();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }

    /** @test */
    public function test_doctor_cannot_delete_prescription_file_that_is_not_from_him()
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
        $response = $this->deleteJson('api/doctor/prescription/'.$submission->id);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }

    /** @test */
    public function test_doctor_cannot_delete_prescription_file_that_is_not_done()
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
        $response = $this->deleteJson('api/doctor/prescription/'.$submission->id);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }

    /** @test */
    public function test_patient_cannot_delete_prescription_file()
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
        $response = $this->deleteJson('api/doctor/prescription/'.$submission->id);
        $response->assertForbidden();
        Storage::assertExists('joaquinsommer/'.$fileName);
    }
}
