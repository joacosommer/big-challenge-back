<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListPendingSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_doctor_can_get_json_list_of_pending_submissions()
    {
        $this->withoutExceptionHandling();
        $doctor = User::factory()->doctor()->create();
        Submission::factory(15)->pending()->create();
        $this->assertCount(15, Submission::all());
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/list/pending');
        $response->assertStatus(200);
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
    public function test_guest_can_not_get_json_list_of_pending_submissions()
    {
        $response = $this->getJson('api/submission/list/pending');
        $response->assertUnauthorized();
    }

    /** @test */
    public function test_patient_can_not_get_json_list_of_pending_submissions()
    {
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->getJson('api/submission/list/pending');
        $response->assertForbidden();
        $response->assertSee([
            'message' => 'User does not have the right roles.',
        ]);
    }

    /** @test */
    public function test_doctor_does_not_get_inProgress_submissions()
    {
        $this->withoutExceptionHandling();
        $doctor = User::factory()->doctor()->create();
        Submission::factory(7)->pending()->create();
        Submission::factory(7)->inProgress()->create();
        $this->assertCount(14, Submission::all());
        $this->actingAs($doctor);
        $response = $this->getJson('api/submission/list/pending');
        $response->assertStatus(200);
        $response->assertJsonCount(7, 'data');
    }

    /** @test */
    public function test_doctor_does_not_get_done_submissions()
    {
        $this->withoutExceptionHandling();
        $doctor = User::factory()->doctor()->create();
        Submission::factory(7)->pending()->create();
        Submission::factory(7)->done()->create();
        $this->assertCount(14, Submission::all());
        $this->actingAs($doctor);
        $response = $this->get('api/submission/list/pending');
        $response->assertStatus(200);
        $response->assertJsonCount(7, 'data');
    }
}
