<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorInformation>
 */
class DoctorInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $user->assignRole('doctor');
        return [
            'user_id' => $user->id,
            'specialty' => $this->faker->word,
            'bank_account_number' => $this->faker->randomNumber(8),
        ];
    }
}
