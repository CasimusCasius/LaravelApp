<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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


    public function genre(): ?BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
