<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ReceiptOfMaterial;
use App\Models\WriteOffOfMaterial;

use App\Models\Nomenclature;

class Detail extends Model
{
    use HasFactory;
	use SoftDeletes;
	
    protected $guarded = [];

    /*
    public function writeoff()
    {
        return $this->belongsTo(WriteOffOfMaterial::class, 'write_off_id');
    }
    */

    public function detailable()
    {
        return $this->morphTo();
    }    

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class);
    }



}
