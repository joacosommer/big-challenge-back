<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPrescriptionFileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_patient_can_get_prescription_file()
    {
        $this->markTestSkipped('This test is skipped');
        $this->withoutExceptionHandling();
        $submission = Submission::factory()->done()->create();
        $patient = $submission->patient;
        $this->actingAs($patient);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'url',
        ]);
    }

    /** @test */
    public function test_doctor_can_get_prescription_file()
    {
        $this->markTestSkipped('This test is skipped');
        $this->withoutExceptionHandling();
        $submission = Submission::factory()->done()->create();
        $doctor = $submission->doctor;
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'url',
        ]);
    }

    /** @test */
    public function test_patient_cannot_get_prescription_file_if_not_done()
    {
        $submission = Submission::factory()->inProgress()->create();
        $patient = $submission->patient;
        $this->actingAs($patient);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_doctor_cannot_get_prescription_file_if_not_done()
    {
        $submission = Submission::factory()->inProgress()->create();
        $doctor = $submission->doctor;
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_patient_cannot_get_prescription_file_if_not_from_patient()
    {
        $submission = Submission::factory()->done()->create();
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_doctor_cannot_get_prescription_file_if_not_from_doctor()
    {
        $submission = Submission::factory()->done()->create();
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_guest_cannot_get_prescription_file()
    {
        $submission = Submission::factory()->done()->create();
        $response = $this->getJson('api/submission/prescription/'.$submission->id);
        $response->assertUnauthorized();
    }
}
