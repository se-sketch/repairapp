<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \App\Models\Role;
use \App\Models\ObjectRepair;
use \App\Models\Nomenclature;
use \App\Models\Subdivision;
use \App\Models\Employee;
use \App\Models\Detail;
use \App\Models\ReceiptOfMaterial;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	//php artisan db:seed

        // \App\Models\User::factory(10)->create();
        
        /*
        Employee::factory()->count(10)->create();
        

        Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin']);
        Role::updateOrCreate(['name' => 'chief'], ['name' => 'chief']);
        Role::updateOrCreate(['name' => 'mechanic'], ['name' => 'mechanic']);


        //Subdivision::factory()->count(5)->create();
        Subdivision::updateOrCreate(['name' => 'Подразд.1'], ['name' => 'Подразд.1']);
        Subdivision::updateOrCreate(['name' => 'Подразд.2'], ['name' => 'Подразд.2']);
        Subdivision::updateOrCreate(['name' => 'Подразд.3'], ['name' => 'Подразд.3']);
        Subdivision::updateOrCreate(['name' => 'Подразд.4'], ['name' => 'Подразд.4']);


        // ObjectRepair::factory(30)->create();

        ObjectRepair::updateOrCreate(['name' => 'mercedes'], ['name' => 'mercedes']);
        ObjectRepair::updateOrCreate(['name' => 'iveco'], ['name' => 'iveco']);
        ObjectRepair::updateOrCreate(['name' => 'vw'], ['name' => 'vw']);
        ObjectRepair::updateOrCreate(['name' => 'man'], ['name' => 'man']);
        ObjectRepair::updateOrCreate(['name' => 'kamaz'], ['name' => 'kamaz']);
        ObjectRepair::updateOrCreate(['name' => 'zaz'], ['name' => 'zaz']);
        ObjectRepair::updateOrCreate(['name' => 'daewoo'], ['name' => 'daewoo']);
        ObjectRepair::updateOrCreate(['name' => 'tatra'], ['name' => 'tatra']);
        ObjectRepair::updateOrCreate(['name' => 'bmw'], ['name' => 'bmw']);
        ObjectRepair::updateOrCreate(['name' => 'mazda'], ['name' => 'mazda']);


        Nomenclature::factory(10)->create();
        */

        //$post = Post::factory()->hasComments(3)->create();



        /*
        $max_sub_id = Subdivision::max('id');
        $max_nom_id = Nomenclature::max('id');

        for ($i=0; $i < 1; $i++) { 

            $data = [
                'active' => 1,
                'user_id' => 1,
                'subdivision_id' => rand(1, $max_sub_id),
            ];
            
            $details[] = [
                'nomenclature_id' => rand(1, $max_nom_id),
                'qty' => rand(1, 50),
            ];
            $details[] = [
                'nomenclature_id' => rand(1, $max_nom_id),
                'qty' => rand(1, 50),
            ];
            $details[] = [
                'nomenclature_id' => rand(1, $max_nom_id),
                'qty' => rand(1, 50),
            ];
            $details[] = [
                'nomenclature_id' => rand(1, $max_nom_id),
                'qty' => rand(1, 50),
            ];

            //dd($details);

            $message = '';

            ReceiptOfMaterial::SaveReceipt($data, $details, $message);

            if (strlen($message) > 0){
                echo $message;
            }
        }
        */


    }
}
