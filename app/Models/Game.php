<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Game extends Model
{
    // WARTOSCI DOMYSLNE - nie wymagają ustawienia
    // protected $table = 'games';   - jeżeli nazwa tabeli jest iina niż liczba mnoga od klasy wymaga zmiany
    // protected $primaryKey = 'id'; - jeżeli klucz główny jest w kolumnie innej niz id
    // protected $timestamps = false; - jezeli nie ma created at i updated at

    // protected static function booted()
    // {
    //     static::addGlobalScope(new LastWeekScope);
    // }


    protected $attributes = [
        'metacritic_score' => null,
    ]; //                          - wartości domyślne dla kolum

    protected $casts =
    [
        'metacritic_score' => 'integer',
        'steam_appid' => 'integer',
    ];
    // protected $fillable = [  //konieczne przy Model::create()
    //     'title', 'description', 'score', 'publisher', 'genre_id'
    // ];

    // ======>ATTRIBUTES<=======
    public function getScoreAttribute(): ?int
    {
        return $this->metacritic_score;
    }
    public function getSteamIdAttribute(): ?int
    {
        return $this->steam_appid;
    }
    public function getShortDescriptionAttribute(): ?string
    {
        return $this->attributes['short_description'];
    }


    // ======>RELATIONS<=======
    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre', 'gameGenres');
    }

    public function publishers()
    {
        return $this->belongsToMany('App\Models\Publisher', 'gamePublishers');
    }



    //scopes

    public function scopeBest(Builder $query): Builder
    {
        return $query
            ->where('metacritic_score', '>=', 90)
            ->orderBy('metacritic_score', 'desc');
    }

    // public function scopeGenre(Builder $query, int $genreId): Builder
    // {
    //     return $query->where('gemdre_id', $genreId);
    // }

    public function scopePublisher(Builder $query, string $publisher): Builder
    {
        return $query->where('publisher', $publisher);
    }
}
