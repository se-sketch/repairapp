<?php

namespace Database\Factories;

use App\Models\Nomenclature;
use Illuminate\Database\Eloquent\Factories\Factory;

class NomenclatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nomenclature::class;

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

        /*
        'name' => Str::random(10),
        'email' => Str::random(10).'@gmail.com',
        'password' => Hash::make('password'),
        */

        /*
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->text(), // Random task description
        */

    }
}
