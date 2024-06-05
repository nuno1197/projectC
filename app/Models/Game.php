<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
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

    public function players()
    {
        return $this->belongsToMany(Player::class, 'game_player');
    }

    public static function remove_players_game($gameID,$player_id)
    {
        $players = Game::find($gameID)->players;
        $game = Game::find(1);
        foreach ($players as $player) {
            if($player->id != $player_id) {
                $game->players()->detach($player->id);
            }
        }

    }

    public static function checkDuplicateRequest($gameID, $playerID): bool
    {
        $players = Game::find($gameID)->players;

        if($players->contains($playerID)){
            return true;
        }

        return false;

    }

}
