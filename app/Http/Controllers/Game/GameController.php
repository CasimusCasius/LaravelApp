<?php

namespace App\Http\Controllers\Game;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repository\GameRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    private GameRepository $gameRepository;
    private int $itemsPerPage = 15;
    private User $user;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function index(Request $request): View
    {

        $phrase = $request->get('phrase');
        $type = $request->get('type', GameRepository::TYPE_DEFAULT);

        $result = $this->gameRepository->filterBy($phrase, $type, $this->itemsPerPage)
            ->appends([
                'phrase' => $phrase,
                'type' => $type
            ]);

        return view('game.list', [
            'games' => $result,
            'phrase' => $phrase,
            'type' => $type
        ]);
    }

    public function dashboard(): View
    {
        return view('game.dashboard', [
            'bestGames' => $this->gameRepository->best(),
            'scoreStats' => $this->gameRepository->scoreStats(),
            'stats' => $this->gameRepository->stats()
        ]);
    }

    public function show(int $gameId): View
    {
        $this->user = Auth::user();
        $userHasGame = $this->user->hasGame($gameId);

        return view('game.show', [
            'game' => $this->gameRepository->get($gameId),
            'userHasGame' => $userHasGame
        ]);
    }
}
