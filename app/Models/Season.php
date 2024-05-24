<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
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
