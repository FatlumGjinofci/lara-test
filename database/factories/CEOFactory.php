<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CEOFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'company_name' => $this->faker->unique()->company,
            'year' => $this->faker->year,
            'company_headquarters' => $this->faker->city,
            'what_company_does' => $this->faker->sentence
        ];
    }
}
