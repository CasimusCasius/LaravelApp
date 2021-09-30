<?php

namespace App\Http\Controllers\Game;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repository\GameRepository;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function index(Request $request): View
    {
        return view('game.list', ['games' => $this->gameRepository->allPaginated(10)]);
    }

    public function dashboard(): View
    {
        return view(
            'game.dashboard',
            [
                'bestGames' => $this->gameRepository->best(),
                'scoreStats' => $this->gameRepository->scoreStats(),
                'stats' => $this->gameRepository->stats()
            ]
        );
    }

    public function show(int $gameId): View
    {
        return view('game.show', ['game' => $this->gameRepository->get($gameId)]);
    }
}
