<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WeightTargetFactory extends Factory
{
    protected $model = \App\Models\WeightTarget::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // 後でSeederで置き換える
            'target_weight' => $this->faker->randomFloat(1, 50, 70),
        ];
    }
}