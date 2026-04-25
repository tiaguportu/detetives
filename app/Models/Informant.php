<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informant extends Model
{
    protected $fillable = ['name', 'image_path'];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_informant');
    }
}
