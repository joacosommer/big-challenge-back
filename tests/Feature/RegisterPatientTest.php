<?php

namespace Tests\Feature;

use App\Models\PatientInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegisterPatientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_patient_can_register()
    {
        Role::create(['name' => 'patient']);
        $response = $this->post('api/registerPatient', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => 'doe@gmail.com',
            'password' => 'password',
            'weight' => '22',
            'height' => '22',
            'insurance_provider' => 'Aetna',
            'current_medications' => null,
            'allergies' => null,
        ]);
        $response->assertSuccessful();
        $this->assertCount(1, User::all());
        $this->assertCount(1, PatientInformation::all());
    }

    public function test_a_doctor_can_not_register_if_already_registered()
    {
        $user = User::factory()->doctor()->create();
        $response = $this->post('api/registerDoctor', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => $user->email,
            'password' => 'password',
            'specialty' => 'Paediatric',
            'bank_account_number' => '123123123',
        ]);
        $response->assertStatus(302);
        $this->assertCount(1, User::all());
    }

    /**
     * @test
     * @dataProvider registerDoctorValidationProvider
     */
    public function test_a_doctor_cannot_register_with_invalid_data($formInput, $formInputValue)
    {
        $data = ['first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => 'doe@gmail.com',
            'password' => 'password',
            'weight' => '22',
            'height' => '22',
            'insurance_provider' => 'Aetna',
            'current_medications' => null,
            'allergies' => null, ];
        $data[$formInput] = $formInputValue;
        Role::create(['name' => 'doctor']);
        $response = $this->post('api/registerDoctor', $data);
        $response->assertStatus(302);
        $this->assertCount(0, User::all());
    }

    public function registerDoctorValidationProvider(): array
    {
        return [
            'The first name field is required.' => ['first_name', ''],
            'last_name_required' => ['last_name', ''],
            'date_of_birth_required' => ['date_of_birth', ''],
            'date_of_birth_invalid' => ['date_of_birth', 'string'],
            'gender_required' => ['gender', ''],
            'phone_number_required' => ['phone_number', ''],
            'address_required' => ['address', ''],
            'email_required' => ['email', ''],
            'email_invalid' => ['email', 'invalid'],
            'password_required' => ['password', ''],
            'weight_required' => ['weight', ''],
            'height_required' => ['height', ''],
            'insurance_provider_required' => ['insurance_provider', ''],
        ];
    }
}
