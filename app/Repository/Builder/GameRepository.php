<?php

declare(strict_types=1);

namespace App\Repository\Builder;

use Illuminate\Support\Facades\DB;
use App\Repository\GameRepository as GameRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use stdClass;

class GameRepository implements GameRepositoryInterface
{


    public function get(int $id)
    {
        $data = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.id as genre_id', 'genres.name as genre_name', 'games.score', 'games.publisher', 'games.description'])
            ->where('games.id', $id)
            ->first();
        return $this->createGame($data);
    }

    public function all()
    {
        return DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.id as genre_id', 'genres.name as genre_name', 'games.score'])
            ->get()->map(fn ($row) => $this->createGame($row));
    }

    public function allPaginated(int $itemsPerPage)
    {
        $page = Paginator::resolveCurrentPage();

        $baseQuery = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id');
        $total = $baseQuery->count();
        $data = collect();
        if ($total)
        {

            $data = $baseQuery
                ->select(['games.id', 'games.title', 'genres.id as genre_id', 'genres.name as genre_name', 'games.score'])
                ->latest('games.created_at')->forPage($page, $itemsPerPage)
                ->get()
                ->map(fn ($row) => $this->createGame($row));
        }

        return new LengthAwarePaginator(
            $data,
            $total,
            $itemsPerPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page'
            ]
        );
    }

    public function best()
    {

        $data =  DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(['games.id', 'games.title', 'genres.id as genre_id', 'genres.name as genre_name', 'games.score'])->where('games.score', '>=', 9)
            ->get()->map(fn ($row) => $this->createGame($row));

        return $data;
    }

    public function stats()
    {
        return [
            'count' => DB::table('games')->count(),
            'countScoreGt7' => DB::table('games')->where('score', '>', 7)->count(),
            'max' => DB::table('games')->max('score'),
            'min' => DB::table('games')->min('score'),
            'avg' => DB::table('games')->avg('score')
        ];
    }

    public function scoreStats()
    {
        return DB::table('games')
            ->select('score', DB::raw('count(*) as count'))
            ->groupBy('score')
            ->having('count', '>=', 10)
            ->orderBy('count', 'desc')
            ->get();
    }

    private function createGame(stdClass $game): stdClass
    {
        $genre = new stdClass();


        $genre->id = $game->genre_id;
        $genre->name = $game->genre_name;

        $game->genre = $genre;

        unset($game->genre_id, $game->genre_name);

        return $game;
    }
}
