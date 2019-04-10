<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function city_regions()
    {
        return $this->belongsTo(Country::class,'region_id');
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
