<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    public $timestamps = false; //error update_at

    protected $fillable = [
        'trainee_id',
        'birth_date',
        'gender',
        'remaining_sessions',
        'avatar_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'trainee_id');
    }
    
}
