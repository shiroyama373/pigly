<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WeightLogFactory extends Factory
{
    protected $model = \App\Models\WeightLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // 後でSeederで置き換える
            'date' => $this->faker->dateTimeBetween('-35 days', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 50, 80),
            'calorie' => $this->faker->numberBetween(1200, 2500),
            'exercise' => $this->faker->numberBetween(0, 120),
            'exercise_content' => $this->faker->sentence(),
        ];
    }
}