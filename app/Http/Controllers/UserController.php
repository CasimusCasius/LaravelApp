<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function list()
    {
        return view('user.list');
    }
}
