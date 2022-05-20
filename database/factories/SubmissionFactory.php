<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => User::factory()->patient()->create(),
            'doctor_id' => null,
            'title' => $this->faker->sentence,
            'date_symptoms_start' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'description' => $this->faker->text,
            'file' => null,
            'status' => Submission::STATUS_PENDING,
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Submission::STATUS_PENDING,
            ];
        });
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Submission::STATUS_IN_PROGRESS,
                'doctor_id' => User::factory()->doctor()->create(),
            ];
        });
    }

    public function done()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Submission::STATUS_DONE,
                'doctor_id' => User::factory()->doctor()->create(),
                'file' => $this->faker->imageUrl(),
            ];
        });
    }
}
