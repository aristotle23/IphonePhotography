<?php

namespace Database\Factories;

use App\Models\WatchedType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WatchedTypeFactory extends Factory
{
    protected $model = WatchedType::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(),
            "watched" =>$this->faker->randomNumber()
        ];
    }
}
