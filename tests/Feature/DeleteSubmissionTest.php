<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_patient_can_delete_his_submission()
    {
        $this->withoutExceptionHandling();
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create(['patient_id' => $patient->id]);
        $this->actingAs($patient);
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertSuccessful();
        $this->assertDatabaseMissing('submissions', [
            'id' => $submission->id,
        ]);
    }

    /** @test */
    public function test_patient_cannot_delete_submission_that_is_inProgress()
    {
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->inProgress()->create(['patient_id' => $patient->id]);
        $this->actingAs($patient);
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
        ]);
    }

    /** @test */
    public function test_patient_cannot_delete_submission_that_is_done()
    {
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->done()->create(['patient_id' => $patient->id]);
        $this->actingAs($patient);
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
        ]);
    }

    /** @test */
    public function test_patient_cannot_delete_other_patients_submission()
    {
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create();
        $this->actingAs($patient);
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
        ]);
    }

    /** @test */
    public function test_doctor_cannot_delete_other_patients_submission()
    {
        $submission = Submission::factory()->pending()->create();
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
        ]);
    }

    /** @test */
    public function test_guest_cannot_delete_submission()
    {
        $submission = Submission::factory()->pending()->create();
        $response = $this->deleteJson('api/submission/'.$submission->id);
        $response->assertStatus(401);
        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
        ]);
    }
}
