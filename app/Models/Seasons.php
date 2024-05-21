<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    use HasFactory;

    protected $fillable = [
        'seasons',

    ];

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }

}