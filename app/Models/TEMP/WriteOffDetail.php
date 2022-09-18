<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\WriteOffOfMaterial;
use App\Models\Nomenclature;

class WriteOffDetail extends Model
{
    use HasFactory;
	use SoftDeletes;
	
    protected $guarded = [];

    public function writeoff()
    {
        return $this->belongsTo(WriteOffOfMaterial::class, 'write_off_id');
    }

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class);
    }



}
