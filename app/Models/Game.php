<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\LastWeekScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    // WARTOSCI DOMYSLNE - nie wymagają ustawienia
    // protected $table = 'games';   - jeżeli nazwa tabeli jest iina niż liczba mnoga od klasy wymaga zmiany
    // protected $primaryKey = 'id'; - jeżeli klucz główny jest w kolumnie innej niz id
    // protected $timestamps = false; - jezeli nie ma created at i updated at
    // protected $atributes = [
    //      'score'=> 5
    // ];                           - wartości domyślne dla kolum

    // protected static function booted()
    // {
    //     static::addGlobalScope(new LastWeekScope);
    // }

    //relations
    public function genre(): ?BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    //scopes

    public function scopeBest(Builder $query): Builder
    {
        return $query
            ->with('genre')
            ->where('score', '>=', 9)
            ->orderBy('score', 'desc');
    }

    public function scopeGenre(Builder $query, int $genreId): Builder
    {
        return $query->where('gemdre_id', $genreId);
    }
}
