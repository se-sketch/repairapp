<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

use \App\Models\OrderDetail;

class OrderMaterial extends Model
{
    use HasFactory;
	use SoftDeletes;
	
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class);
    }


    public static function SaveOrder($data, $details, &$message){

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

            $order = OrderMaterial::create($data);

            $order->details()->createMany($details);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();

            $message = $e->getMessage();
            
            return 0;
        }

        return $order->id;
    }

    public static function UpdateOrder($data, $details, &$message, $order){

        if (sizeof($details) == 0) {
            $message = 'Документ не записан. Отсутствуют детали!';
            return false;
        }
        
        DB::beginTransaction();

        try{

            $order->update($data);
            
            $order->details()->delete();

            $order->details()->createMany($details);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();

            $message = $e->getMessage();
            
            return false;
        }

        return true;
    }     

}
