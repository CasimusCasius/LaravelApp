<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GameController extends Controller
{
    // CRUD
    // C - create
    // R - read
    // U - update
    // D - delete

    public function index(): View
    {
        $games = DB::table('games')
            ->join('generes', 'games.genere_id', '=', 'generes.id')
            ->select(['games.id', 'games.title', 'generes.name as genres_name', 'games.score'])
            // ->orderBy('games.score', 'desc')
            // ->limit(10)
            // ->offset(20)
            //->get();
            ->paginate(10);

        return view('game.list', ['games' => $games]);
    }



    public function dashboard(): View
    {
        $bestGames = DB::table('games')
            ->join('generes', 'games.genere_id', '=', 'generes.id')
            ->select(['games.id', 'games.title', 'generes.name as genres_name', 'games.score'])->where('games.score', '>=', 9)->get();

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
            'game.dashboard',
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
        $game = DB::table('games')->join('generes', 'games.genere_id', '=', 'generes.id')->where('games.id', $gameId)
            ->first();
        //dd($game);
        return view('game.show', ['game' => $game]);
    }



    /**
     * @return Response
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
