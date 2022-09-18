<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

//use App\Models\WriteOffDetail;
use App\Models\Detail;

use App\Models\User;
use App\Models\Subdivision;
use App\Models\ObjectRepair;


class WriteOffOfMaterial extends Model
{
    use HasFactory;
	use SoftDeletes;
	
    protected $guarded = [];

    /*
    public function details()
    {
        return $this->hasMany(WriteOffDetail::class, 'write_off_id');
    }
    */
    public function details()
    {
        return $this->morphMany(Detail::class, 'detailable');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class);
    }

    public function object_repair()
    {
        return $this->belongsTo(ObjectRepair::class, "object_id");
    }


    public static function SaveWriteOff($data, $details, &$message){

        if (sizeof($details) == 0) {
            $message = 'Документ не записан. Отсутствуют детали документа!';
            return 0;
        }        

        /*
        if (Order::itsSpam())
        {
            $error = 'Пожалуйста повторите попытку!';
            return 0;
        }        
        */

        
        DB::beginTransaction();

        try{

            $writeoff = WriteOffOfMaterial::create($data);

            $writeoff->details()->createMany($details);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();

            $message = $e->getMessage();
            
            return 0;
        }

        return $writeoff->id;
    }

    public static function UpdateWriteOff($data, $details, &$message, $writeoff){

        if (sizeof($details) == 0) {
            $message = 'Документ не записан. Отсутствуют детали!';
            return false;
        }
        
        DB::beginTransaction();

        try{

            $writeoff->update($data);
            
            $writeoff->details()->delete();

            $writeoff->details()->createMany($details);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();

            $message = $e->getMessage();
            
            return false;
        }

        return true;
    }       

    
}
