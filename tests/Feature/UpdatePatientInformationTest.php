<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePatientInformationTest extends \Tests\TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_patient_can_update_information()
    {
        $patient = User::factory()->patient()->create();
        $this->actingAs($patient);
        $response = $this->put('api/patient/update', [
            'weight' => '100',
            'height' => '100',
            'insurance_provider' => 'Aetna',
            'current_medications' => 'Aspirin',
            'allergies' => 'Penicillin',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('patient_information', [
            'user_id' => $patient->id,
            'weight' => '100',
            'height' => '100',
            'insurance_provider' => 'Aetna',
            'current_medications' => 'Aspirin',
            'allergies' => 'Penicillin',
        ]);
    }

    /** @test */
    public function test_patient_cannot_update_if_not_logged_in()
    {
        $patient = User::factory()->patient()->create();
        $response = $this->put('api/patient/update', [
            'weight' => '100',
            'height' => '100',
            'insurance_provider' => 'Aetna',
            'current_medications' => 'Aspirin',
            'allergies' => 'Penicillin',
        ]);
        $response->assertStatus(302);
    }
}
