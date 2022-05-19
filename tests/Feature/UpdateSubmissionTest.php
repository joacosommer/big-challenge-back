<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_submission_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create([
            'patient_id' => $patient->id,
        ]);
        $this->actingAs($patient);
        $response = $this->put("api/submission/{$submission->id}", [
            'title' => 'New Title',
            'date_symptoms_start' => '2020-01-01',
            'description' => 'New Description',
        ]);
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'id' => $submission->id,
                'patient_id' => $patient->id,
                'title' => 'New Title',
                'date_symptoms_start' => '2020-01-01',
                'description' => 'New Description',
                'status' => 'pending',
            ],
        ]);
    }

    /** @test */
    public function test_patient_cannot_update_submission_of_another_patient()
    {
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create();
        $this->actingAs($patient);
        $response = $this->put('api/submission/'.$submission['id'], [
            'title' => 'New Title',
            'date_symptoms_start' => '2020-01-01',
            'description' => 'New Description',
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_guest_cannot_update_submission()
    {
        $submission = Submission::factory()->pending()->create();
        $response = $this->put('api/submission/'.$submission['id'], [
            'title' => 'New Title',
            'date_symptoms_start' => '2020-01-01',
            'description' => 'New Description',
        ]);
        $response->assertStatus(302);
    }
}
