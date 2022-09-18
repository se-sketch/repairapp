<?php

namespace Database\Factories;

use App\Models\Detail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'' => Str::random(10),
            //'' => $this->faker->name,            
        ];

        /*
| id              | bigint unsigned        | NO   | PRI | NULL    | auto_increment |
| detailable_id   | bigint unsigned        | NO   | MUL | NULL    |                |
| detailable_type | varchar(255)           | NO   |     | NULL    |                |
| nomenclature_id | bigint unsigned        | NO   | MUL | NULL    |                |
| qty          
        */
    }
}
