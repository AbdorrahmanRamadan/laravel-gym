<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'name',
        'cover_image',
        'created_by'

    ];
    public function user()
    {
       return $this->belongsTo(User::class, 'created_by');
    }
    public function city()
    {
       return $this->belongsTo(City::class, 'city_id');
    }
    public function bought_package()
    {
        return $this->hasMany(BoughtPackage::class);
    }

}
