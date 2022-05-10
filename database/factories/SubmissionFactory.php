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
        $status = $this->faker->randomElement([Submission::STATUS_PENDING, Submission::STATUS_DONE, Submission::STATUS_IN_PROGRESS]);

        return [
            'patient_id' => User::factory()->patient()->create(),
            'doctor_id' => $status != Submission::STATUS_PENDING ? User::factory()->doctor()->create() : null,
            'title' => $this->faker->sentence,
            'date_symptoms_start' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'description' => $this->faker->text,
            'file' => $status === Submission::STATUS_DONE ? $this->faker->url() : null,
            'status' => $status,
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
            ];
        })->afterCreating(function (Submission $submission) {
            $submission->doctor_id = User::factory()->doctor()->create()->id;
            $submission->save();
        });
    }

    public function done()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Submission::STATUS_DONE,
            ];
        })->afterCreating(function (Submission $submission) {
            $submission->doctor_id = User::factory()->doctor()->create()->id;
            $submission->file = $this->faker->url();
            $submission->save();
        });
    }
}
