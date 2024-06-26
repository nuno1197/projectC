<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Practice extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function roster(): BelongsTo
    {
        return $this->belongsTo(Roster::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function drills()
    {
        return $this->belongsToMany(Drill::class, 'drill_practice');
    }
}
