<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    public function town_regions()
    {
        return $this->belongsTo(Country::class,'region_id');
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
