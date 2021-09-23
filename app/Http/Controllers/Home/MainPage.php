<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainPage extends Controller
{
    public function __invoke()
    {
        $db = DB::connection();

        dd($db);

        $config = config('app.name');

        return view('home.main');
    }
}
