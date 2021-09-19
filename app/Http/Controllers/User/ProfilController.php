<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function show()
    {
        return view('user.profile');
    }
}
