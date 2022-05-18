<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_patient_can_create_submission()
    {
        $this->withoutExceptionHandling();
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->post('api/submission/create', [
            'title' => 'Test submission',
            'description' => 'Test submission description',
            'date_symptoms_start' => '2020-01-01',
        ]);
        $response->assertStatus(201);
        $this->assertCount(1, $patient->patientSubmission);
    }

    /** @test */
    public function test_guest_cannot_create_submission()
    {
        $response = $this->post('api/submission/create', [
            'title' => 'Test submission',
            'description' => 'Test submission description',
            'date_symptoms_start' => '2020-01-01',
        ], ['Accept' => 'application/json']);
        $response->assertUnauthorized();
        $this->assertCount(0, Submission::all());
    }

    /** @test */
    public function test_a_doctor_cannot_create_submission()
    {
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->post('api/submission/create', [
            'title' => 'Test submission',
            'description' => 'Test submission description',
            'date_symptoms_start' => '2020-01-01',
        ]);
        $response->assertStatus(403);
        $this->assertCount(0, Submission::all());
    }

    /**
     * @test
     * @dataProvider CreateSubmissionValidationProvider
     */
    public function test_a_patient_cannot_create_submission_with_invalid_data($formInput, $formInputValue)
    {
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $submission = Submission::factory()->create();
        $data = [
            'title' => 'Test submission',
            'description' => 'Test submission description',
            'date_symptoms_start' => '2020-01-01',
        ];
        $data[$formInput] = $formInputValue;
        $response = $this->postJson('api/submission/create', $data);
        $response->assertStatus(422);
    }

    public function CreateSubmissionValidationProvider(): array
    {
        return [
            ['title', ''],
            ['description', ''],
            ['date_symptoms_start', ''],
        ];
    }
}
