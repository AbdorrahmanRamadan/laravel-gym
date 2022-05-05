<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoughtPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainee_id',
        'gym_id',
        'training_package_id',
        'purchase_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'trainee_id');
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
    public function training_package()
    {
        return $this->belongsTo(TrainingPackage::class);
    }
}
