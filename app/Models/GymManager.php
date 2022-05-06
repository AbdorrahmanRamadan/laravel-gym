<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymManager extends Model
{
    use HasFactory;
    public function gym()
    {
       return $this->belongsTo(Gym::class, 'gym_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    protected $fillable = [
        'isban',
    ];
}
