<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EloquentController extends Controller
{
    public function index(): View
    {
        $games = Game::orderBy('created_at')->paginate(10);

        return view('game.eloquent.list', ['games' => $games]);
    }

    public function dashboard(): View
    {
        $bestGames = Game::where('games.score', '>=', 9)->get();

        $oldBestGames = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.name as genres_name', 'games.score'])->where('games.score', '>=', 9)->get();

        $stats = [
            'count' => Game::count(),
            'countScoreGt7' => Game::where('score', '>', 7)->count(),
            'max' => Game::max('score'),
            'min' => Game::min('score'),
            'avg' => Game::avg('score')
        ];

        $scoreStats = Game::select('score', Game::raw('count(*) as count'))
            ->groupBy('score')
            ->having('count', '>=', 10)
            ->orderBy('count', 'desc')
            ->get();

        return view(
            'game.eloquent.dashboard',
            [
                'bestGames' => $bestGames,
                'scoreStats' => $scoreStats,
                'stats' => $stats
            ]
        );
    }

    public function show(int $gameId): View
    {
        $game = Game::findOrFail($gameId);

        return view('game.eloquent.show', ['game' => $game]);
    }
}
