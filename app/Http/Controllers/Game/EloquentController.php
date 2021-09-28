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

        // $newGame = new Game();
        // $newGame->title = 'Tomb Rider';
        // $newGame->description = 'Grobowce, przygoda, skarby';
        // $newGame->score = 9;
        // $newGame->publisher = 'Eidos';
        // $newGame->genre_id = 4;
        // $newGame->save();

        // Game::create([
        //     'title' => 'Dune 2',
        //     'description' => ' Strategia w świecie pustynnym',
        //     'score' => 10,
        //     'publisher' => 'Eidos',
        //     'genre_id' => 5
        // ]);

        /*
        $newGame = new Game(
            [
                'title' => 'Commandos',
                'description' => ' Skradanka w realich II Wojny Światowej',
                'score' => 10,
                'publisher' => 'Eidos',
                'genre_id' => 5
            ]
        );
        $newGame->save(); */

        //$game = Game::find(104);
        // $game->description = 'Skradanka w realich II WW ';
        // $game->save();
        // $gamesIds = [87, 89, 93, 100];

        // Game::whereIn('id', $gamesIds)
        //     ->update([
        //         'description' => 'bez pobierania'
        //     ]);
        //
        //$game = Game::find(104);
        //$game->delete();

        //Game::destroy(120,121) -

        $games = Game::with('genre') //->publisher('Eidos')
            ->orderBy('created_at')
            ->paginate(10);

        return view('game.eloquent.list', ['games' => $games]);
    }

    public function dashboard(): View
    {
        $bestGames = Game::best()->get();

        // $oldBestGames = DB::table('games')
        //     ->join('genres', 'games.genre_id', '=', 'genres.id')
        //     ->select(['games.id', 'games.title', 'genres.name as genres_name', 'games.score'])->where('games.score', '>=', 9)->get();

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
