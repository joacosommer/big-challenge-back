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
            'patient_id' => User::factory()->create()->syncRoles(['patient']),
            'doctor_id' => null,
            'title' => $this->faker->sentence,
            'date_symptoms_start' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'description' => $this->faker->text,
            'file' => null,
            'status' => 'pending',
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in_progress',
            ];
        })->afterCreating(function (Submission $submission) {
            $submission->doctor_id = User::factory()->create()->syncRoles(['doctor'])->id;
            $submission->save();
        });
    }

    public function done()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'done',
            ];
        })->afterCreating(function (Submission $submission) {
            $submission->doctor_id = User::factory()->create()->syncRoles(['doctor'])->id;
            $submission->file = $this->faker->url();
            $submission->save();
        });
    }
}
