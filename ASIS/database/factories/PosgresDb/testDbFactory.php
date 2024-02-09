<?php

namespace Database\Factories\posgres_db;

use Illuminate\Database\Eloquent\Factories\Factory;

class testDbFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

            return [
                'name' => $this->faker->name,

            ];

    }
}
