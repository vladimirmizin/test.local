<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function regions_country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function regions_city()
    {
        return $this->hasMany(City::class);
    }

}
