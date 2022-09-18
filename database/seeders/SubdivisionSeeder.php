<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Subdivision;

class SubdivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subdivision::factory()->count(5)->create();
    }
}
