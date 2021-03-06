<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientInformation>
 */
class PatientInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'weight' => $this->faker->numberBetween(20, 150),
            'height' => $this->faker->numberBetween(20, 150),
            'insurance_provider' => $this->faker->company,
            'current_medications' => $this->faker->sentence,
            'allergies' => $this->faker->sentence,
        ];
    }
}
