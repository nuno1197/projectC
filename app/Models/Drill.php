<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function practices()
    {
        return $this->belongsToMany(Practice::class, 'drill_practice');
    }

    public function canvasStates()
    {
        return $this->hasMany(CanvasState::class);
    }

}
