<?php

namespace App\Models;

use App\Models\Game;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addGame(Game $game): void
    {

        $this->games()->save($game);
    }

    public function removeGame(Game $game): void
    {
        $this->games()->detach($game->id);
    }

    public function rateGame(Game $game, ?int $rate = null): void
    {
        $this->games()->updateExistingPivot($game, ['rate' => $rate]);
    }

    public function hasGame(int $gameId): bool
    {
        $game = $this->games()->where('userGames.game_id', $gameId)->first();
        return (bool) $game;
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'userGames')->withPivot('rate')->with('genres');
    }
}
