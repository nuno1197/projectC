<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roster extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seasons(): BelongsTo
    {
        return $this->belongsTo(Seasons::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    public function practices(): BelongsToMany
    {
        return $this->belongsToMany(Practice::class);
    }
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }
}
