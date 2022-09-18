<?php

namespace Database\Factories;

use App\Models\ObjectRepair;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectRepairFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObjectRepair::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'name' => $this->faker->name,
            'name' => $this->faker->word(),
        ];
    }
}
