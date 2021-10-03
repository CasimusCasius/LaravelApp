<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    public function games()
    {
        return $this->belongsToMany('App\Models\Game', 'gameGenres');
    }
}
