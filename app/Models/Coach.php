<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    public $timestamps = false; //error update_at

    protected $fillable = [
        'coach_id',
        'national_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
    public function sessions(){
        return $this->belongsToMany(TrainingSession::class, 'coach_sessions');
    }
}
