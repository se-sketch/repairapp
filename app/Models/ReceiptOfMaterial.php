<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

//use App\Models\ReceiptDetails;
use App\Models\ReceiptOfMaterial;
use App\Models\Detail;

use App\Models\User;
use App\Models\Subdivision;
use App\Models\ObjectRepair;

class ReceiptOfMaterial extends Model
{
    use HasFactory;
	use SoftDeletes;
	
    protected $guarded = [];

    /*
    public function details()
    {
        return $this->hasMany(ReceiptDetails::class, 'receipt_id');
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

    public static function SaveReceipt($data, $details, &$message){

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

            $receipt = ReceiptOfMaterial::create($data);

            $receipt->details()->createMany($details);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();

            $message = $e->getMessage();
            
            return 0;
        }

        return $receipt->id;
    }    


}
