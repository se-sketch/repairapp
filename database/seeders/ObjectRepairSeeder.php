<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ObjectRepair;

class ObjectRepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ObjectRepair::factory()->count(30)->create();
    }
}
