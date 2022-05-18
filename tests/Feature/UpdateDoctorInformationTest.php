<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateDoctorInformationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_doctor_can_update_information()
    {
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->put('api/doctor/update', [
            'specialty' => 'Cardiologist',
            'bank_account_number' => '123456789',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('doctor_information', [
            'user_id' => $doctor->id,
            'specialty' => 'Cardiologist',
            'bank_account_number' => '123456789',
        ]);
    }

    /** @test */
    public function test_doctor_cannot_update_if_not_logged_in()
    {
        $doctor = User::factory()->doctor()->create();
        $response = $this->put('api/doctor/update', [
            'specialty' => 'Cardiologist',
            'bank_account_number' => '123456789',
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function test_doctor_cannot_update_if_not_doctor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->put('api/doctor/update', [
            'specialty' => 'Cardiologist',
            'bank_account_number' => '123456789',
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function test_doctor_cannot_update_information_with_blank_specialty()
    {
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->put('api/doctor/update', [
            'specialty' => '',
            'bank_account_number' => '123456789',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('specialty');
    }

    /** @test */
    public function test_doctor_cannot_update_information_with_blank_bank_account_number()
    {
        $doctor = User::factory()->doctor()->create();
        $this->actingAs($doctor);
        $response = $this->put('api/doctor/update', [
            'specialty' => 'Cardiologist',
            'bank_account_number' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('bank_account_number');
    }
}
