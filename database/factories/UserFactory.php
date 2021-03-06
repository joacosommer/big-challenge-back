<?php

namespace Database\Factories;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function doctor(): self
    {
        return $this->afterCreating(function (User $user) {
            try {
                Role::create(['name' => 'doctor']);
            } catch (RoleAlreadyExists $e) {
                //
            }
            $user->assignRole('doctor');
            DoctorInformation::factory()->create([
                'user_id' => $user['id'],
            ]);
        });
    }

    public function patient(): self
    {
        return $this->afterCreating(function (User $user) {
            try {
                Role::create(['name' => 'patient']);
            } catch (RoleAlreadyExists $e) {
                //
            }
            $user->assignRole('patient');
            PatientInformation::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
