<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_doctor_can_get_the_submissions_assign_to_him()
    {
        $this->withDeprecationHandling();
        $doctor = User::factory()->doctor()
            ->has(Submission::factory(4)->inProgress(), 'doctorSubmission')
            ->has(Submission::factory(4)->done(), 'doctorSubmission')
            ->create();
        Submission::factory(4)->pending()->create();
        $this->assertCount(8, Submission::where('doctor_id', $doctor->id)->get());
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/list/all');
        $response->assertStatus(200);
        $response->assertJsonCount(8, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'patient_id',
                    'doctor_id',
                    'title',
                    'description',
                    'date_symptoms_start',
                    'status',
                    'file',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }

    /** @test */
    public function test_patient_can_get_the_submissions_assign_to_him()
    {
        $this->withDeprecationHandling();
        $patient = User::factory()->patient()
            ->has(Submission::factory(4)->pending(), 'patientSubmission')
            ->has(Submission::factory(4)->inProgress(), 'patientSubmission')
            ->has(Submission::factory(4)->done(), 'patientSubmission')
            ->create();
        Submission::factory(4)->pending()->create();
        Submission::factory(4)->inProgress()->create();
        $this->assertCount(12, Submission::where('patient_id', $patient->id)->get());
        $this->actingAs($patient);
        $response = $this->getJson('api/submission/list/all');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'patient_id',
                    'doctor_id',
                    'title',
                    'description',
                    'date_symptoms_start',
                    'status',
                    'file',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }

    /** @test */
    public function test_guest_can_not_get_json_list_of_submissions()
    {
        $response = $this->getJson('api/submission/list/all');
        $response->assertUnauthorized();
    }
}
