<?php

namespace Tests\Feature;

use App\Models\PatientInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PatientInfoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_patient_login_can_get_patient_info()
    {
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->get('api/patient/info');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'first_name' => $patient['first_name'],
            'last_name' => $patient['last_name'],
            'email' => $patient['email'],
            'address' => $patient['address'],
            'height' => PatientInformation::where('user_id', $patient['id'])->first()['height'],
            'weight' => PatientInformation::where('user_id', $patient['id'])->first()['weight'],
            ]);
    }

    /** @test */
    public function test_guest_can_not_get_patient_info()
    {
        $response = $this->get('api/patient/info');
        $response->assertStatus(302);
        $response->assertSee('Unauthorized');
    }

    /** @test */
    public function test_doctor_can_not_get_patient_info()
    {
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->get('api/patient/info');
        $response->assertStatus(403);
        $response->assertSee([
            'message' => 'User does not have the right roles.',
        ]);
    }
}
