<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use \App\Models\OrderMaterial;
use \App\Models\Nomenclature;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(OrderMaterial::class, 'order_material_id');
    }

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class);
    }

}
