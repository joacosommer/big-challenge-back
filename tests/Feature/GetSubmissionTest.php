<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_patient_can_get_a_submission()
    {
        $this->withDeprecationHandling();
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create([
            'patient_id' => $patient['id'],
        ]);
        $this->actingAs($patient);
        $response = $this->get('api/submission/'.$submission['id']);
        $response->assertSuccessful();
        $response->assertJsonStructure();
    }

    /** @test */
    public function test_a_doctor_can_get_any_submission()
    {
        $this->withDeprecationHandling();
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        Submission::factory(2)->pending()->create();
        $this->actingAs($doctor);
        $response1 = $this->get('api/submission/'. 1);
        $response2 = $this->get('api/submission/'. 2);
        $response1->assertSuccessful();
        $response2->assertSuccessful();
        $response1->assertJsonStructure();
        $response2->assertJsonStructure();
    }

    /** @test */
    public function test_a_patient_cannot_get_submission_of_another_patient()
    {
        $this->withDeprecationHandling();
        $patient = User::factory()->patient()->create();
        $submission = Submission::factory()->pending()->create([
            'patient_id' => $patient['id'],
        ]);
        $anotherPatient = User::factory()->patient()->create();
        $this->actingAs($anotherPatient);
        $response = $this->get('api/submission/'.$submission['id']);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_guest_cannot_get_submission()
    {
        $this->withDeprecationHandling();
        $submission = Submission::factory()->pending()->create();
        $response = $this->get('api/submission/'.$submission['id']);
        $response->assertStatus(302);
    }
}
