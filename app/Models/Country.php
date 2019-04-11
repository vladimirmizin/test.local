<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function country_regions()
    {
        return $this->hasMany(Region::class);
    }
    public static function getCountries()
    {
        $countries = Country::all();
        return view('auth/register', ['country' => $countries]);
    }
}
