<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Nomenclature;

class NomenclatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nomenclature::factory()->count(1000)->create();
    }
}
