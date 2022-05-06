<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymManager extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_id',
        'id',
        'gym_id',
        'avatar_image',
        'isban',
    ];
    public function gym(){
        return $this->belongsTo(Gym::class,'gym_id','id');

    }
    public function user()
    {
       return $this->belongsTo(User::class,'id');
    }
    
}
