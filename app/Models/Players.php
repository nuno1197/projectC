<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Players extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function roster(): BelongsTo
    {
        return $this->belongsTo(Roster::class);
    }
}
