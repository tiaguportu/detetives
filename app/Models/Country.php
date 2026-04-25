<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function informant()
    {
        return $this->belongsTo(Informant::class);
    }

    public function curiosities()
    {
        return $this->hasMany(CountryCuriosity::class);
    }

    public function clues()
    {
        return $this->hasMany(Clue::class);
    }

    public function images()
    {
        return $this->hasMany(CountryImage::class)->orderBy('sort_order');
    }

    public function informants()
    {
        return $this->belongsToMany(Informant::class, 'country_informant');
    }

    public function getRandomInformantAttribute()
    {
        return $this->informants()->inRandomOrder()->first();
    }
}
