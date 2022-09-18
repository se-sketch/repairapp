<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use App\Auxiliary;
//use App\Others\StanceSettlements;
use App\Others\AddressKlisifierLoader;

class UploadSettlements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'other:uploadsettlements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload settlements from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirm("Are you ready to upload regions, districts, cities ?")){
            return;
        }

        $start = time();

        $this->info("".date("H:i:s")." . start!");


        //$result = StanceSettlements::upload_settlements($fullupload, $flag_update);

        $result = AddressKlisifierLoader::getRegions();

        if ($result){
            $result = AddressKlisifierLoader::getDistricts();
        }
        
        if ($result){
            $result = AddressKlisifierLoader::getCities();
        }
        

        $delta = round( (time() - $start)/60 );

        $this->info('');

        if ($result){
            $this->info(''.date('H:i:s').' . Upload completed successfully. '.$delta.' minutes');
        }else{
            $this->warn(''.date('H:i:s').' . Something went wrong. '.$delta.' minutes');
        }
    }
}
