<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainee_id',
        'training_session_id',
        'attendance_time',

    ];
    public function user()
    {
        return $this->belongsTo(User::class,'trainee_id');
    }

    public function training_session()
    {
        return $this->belongsTo(TrainingSession::class,'training_session_id');
    }



}
