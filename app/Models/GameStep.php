<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStep extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    public function targetCountry()
    {
        return $this->belongsTo(Country::class, 'target_country_id');
    }
}
