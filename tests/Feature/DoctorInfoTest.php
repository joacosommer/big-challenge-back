<?php

namespace Tests\Feature;

use App\Models\DoctorInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorInfoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_doctor_login_can_view_doctor_info()
    {
        $this->withoutExceptionHandling();
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->get('api/doctor/info');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'first_name' => $doctor['first_name'],
            'last_name' => $doctor['last_name'],
            'email' => $doctor['email'],
            'address' => $doctor['address'],
            'specialty' => DoctorInformation::where('user_id', $doctor['id'])->first()['specialty'],
            'bank_account_number' => DoctorInformation::where('user_id', $doctor['id'])->first()['bank_account_number'],
        ]);
    }

    /** @test */
    public function test_guest_can_not_get_doctor_info()
    {
        $response = $this->get('api/doctor/info');
        $response->assertStatus(302);
        $response->assertSee('Unauthorized');
    }

    /** @test */
    public function test_patient_can_not_get_doctor_info()
    {
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->get('api/doctor/info');
        $response->assertStatus(403);
        $response->assertSee([
            'message' => 'User does not have the right roles.',
        ]);
    }
}
