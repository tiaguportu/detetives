<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'path' => 'array',
    ];

    public function investigator()
    {
        return $this->belongsTo(Investigator::class);
    }

    public function gameSteps()
    {
        return $this->hasMany(GameStep::class);
    }
}
