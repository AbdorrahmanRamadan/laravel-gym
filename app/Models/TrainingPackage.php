<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'number_of_sessions',
    ];
    // public function bought_package()
    // {
    //     return $this->hasMany(BoughtPackage::class);
    // }
}
