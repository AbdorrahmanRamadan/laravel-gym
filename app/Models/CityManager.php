<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityManager extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function cities(){
        return $this->belongsTo(City::class,'city_id');

    }

    public function user()
    {
       return $this->belongsTo(User::class,'city_manager_id');
    }
}
