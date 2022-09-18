<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Encryption\DecryptException;

class Employee extends Model
{
	use HasFactory;
    protected $guarded = [];

    protected $casts = ['id' => 'string'];
    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }    

    public function getNameAttribute($value)
    {
        $decrypted = '';

        try{
            $decrypted = decrypt($value);
        }catch(DecryptException $e){
            //dd($e->getMessage()); 
        }

        return trim($decrypted);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = encrypt($value);
    }    

}