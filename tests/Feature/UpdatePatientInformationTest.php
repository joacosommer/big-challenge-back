<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePatientInformationTest extends TestCase
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

    /** @test */
    public function test_patient_cannot_update_if_not_patient()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->put('api/patient/update', [
            'weight' => '100',
            'height' => '100',
            'insurance_provider' => 'Aetna',
            'current_medications' => 'Aspirin',
            'allergies' => 'Penicillin',
        ]);
        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider updatePatientValidationProvider
     */
    public function test_a_doctor_cannot_update_with_invalid_data($formInput, $formInputValue)
    {
        $patient = User::factory()->patient()->create();
        $data = [
            'weight' => $patient->weight,
            'height' => $patient->height,
            'insurance_provider' => $patient->insurance_provider,
            'current_medications' => $patient->current_medications,
            'allergies' => $patient->allergies,
        ];
        $data[$formInput] = $formInputValue;
        $response = $this->put('api/patient/update', $data);
        $response->assertStatus(302);
    }

    public function updatePatientValidationProvider(): array
    {
        return [
            'weight_required' => ['weight', ''],
            'height_required' => ['height', ''],
            'insurance_provider_required' => ['insurance_provider', ''],
        ];
    }
}
