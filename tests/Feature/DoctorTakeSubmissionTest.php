<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorTakeSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_doctor_can_take_submission_pending()
    {
        $this->withoutExceptionHandling();
        $doctor = User::factory()->doctor()->create();
        $submission = Submission::factory()->pending()->create();
        $this->actingAs($doctor);
        $response = $this->putJson('api/doctor/take/'.$submission->id);
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'id' => $submission['id'],
                'patient_id' => $submission['patient_id'],
                'doctor_id' => $doctor['id'],
                'status' => Submission::STATUS_IN_PROGRESS,
            ],
            'message' => 'Successfully take submission.',
            'status' => 200,
        ]);
    }

    /** @test */
    public function test_doctor_cannot_take_submission_in_progress()
    {
        $doctor = User::factory()->doctor()->create();
        $submission = Submission::factory()->inProgress()->create();
        $this->actingAs($doctor);
        $response = $this->putJson('api/doctor/take/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_doctor_cannot_take_submission_done()
    {
        $doctor = User::factory()->doctor()->create();
        $submission = Submission::factory()->done()->create();
        $this->actingAs($doctor);
        $response = $this->putJson('api/doctor/take/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_patient_cannot_take_submission()
    {
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create();
        $this->actingAs($patient);
        $response = $this->putJson('api/doctor/take/'.$submission->id);
        $response->assertForbidden();
    }

    /** @test */
    public function test_guest_cannot_take_submission()
    {
        $submission = Submission::factory()->pending()->create();
        $response = $this->putJson('api/doctor/take/'.$submission->id);
        $response->assertUnauthorized();
    }
}
