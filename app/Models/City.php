<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function city_manager()
    {
       return $this->belongsTo(CityManager::class,'id','city_id');
    }
}
