<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use faker
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UplinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'deviceName' => $this->faker->word,
            'devEUI' => $this->faker->randomDigit(),
            'date' => $this->faker->date(),
            'payloads' => collect([
                'temperature' => $this->faker->randomFloat(2, 0, 100),
                'humidity' => $this->faker->randomFloat(2, 0, 100),
                'pressure' => $this->faker->randomFloat(2, 0, 100),
                'battery' => $this->faker->randomFloat(2, 0, 100),
            ])->toArray(),
        ];
    }
}
