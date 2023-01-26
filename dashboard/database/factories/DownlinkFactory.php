<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Downlink>
 */
class DownlinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'device_id' => $this->faker->word,
            'command' => $this->faker->word,
            'payload' => $this->faker->numberBetween(0, 3),
            'port' => $this->faker->numberBetween(1, 255),
        ];
    }
}
