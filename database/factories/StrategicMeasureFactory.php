<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\StrategicMeasure>
 */
class StrategicMeasureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'strategic_measures' => $this->faker->sentence,
            'strategic_objectives_ID' => $this->faker->numberBetween(1,15)
        ];
    }
}
