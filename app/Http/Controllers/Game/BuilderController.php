<?php

declare(strict_types=1);

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BuilderController extends Controller
{
    // CRUD
    // C - create
    // R - read
    // U - update
    // D - delete

    public function index(): View
    {
        $games = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.name as genres_name', 'games.score'])
            // ->orderBy('games.score', 'desc')
            // ->limit(10)
            // ->offset(20)
            //->get();
            ->paginate(10);

        return view('game.builder.list', ['games' => $games]);
    }



    public function dashboard(): View
    {
        $bestGames = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.name as genres_name', 'games.score'])->where('games.score', '>=', 9)->get();

        $stats = [
            'count' => DB::table('games')->count(),
            'countScoreGt7' => DB::table('games')->where('score', '>', 7)->count(),
            'max' => DB::table('games')->max('score'),
            'min' => DB::table('games')->min('score'),
            'avg' => DB::table('games')->avg('score')
        ];

        $scoreStats = DB::table('games')
            ->select('score', DB::raw('count(*) as count'))
            ->groupBy('score')
            ->having('count', '>=', 10)
            ->orderBy('count', 'desc')
            ->get();



        return view(
            'game.builder.dashboard',
            [

                'bestGames' => $bestGames,
                'scoreStats' => $scoreStats,
                'stats' => $stats
            ]
        );
    }

    public function show(int $gameId): View
    {
        //$game = DB::table('games')->where('id', $gameId)->first();
        $game = DB::table('games')->join('genres', 'games.genre_id', '=', 'genres.id')->where('games.id', $gameId)
            ->first();
        //dd($game);
        return view('game.builder.show', ['game' => $game]);
    }
}
