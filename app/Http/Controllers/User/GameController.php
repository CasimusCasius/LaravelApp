<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddGameToUserList;
use App\Http\Requests\RateGame;
use App\Http\Requests\RemoveGameFromUserList;
use App\Models\User;
use App\Repository\GameRepository;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{
    private GameRepository $repository;


    public function __construct(GameRepository $gameRepository)
    {
        $this->repository = $gameRepository;
    }
    public function list()
    {
        $user = $this->user();

        return view('me.game.list', ['games' => $user->games()->paginate()]);
    }


    public function add(AddGameToUserList $request)
    {
        $validatedRequest = $request->validated();
        $gameId = (int) $validatedRequest['gameId'];
        $game = $this->repository->get($gameId);

        $this->user()->addGame($game);

        return redirect()->route('games.show', ['game' => $gameId])
            ->with('success', 'Gra została dodana do Twojej listy');
    }

    public function remove(RemoveGameFromUserList $request)
    {
        $validatedRequest = $request->validated();
        $gameId = (int) $validatedRequest['gameId'];
        $game = $this->repository->get($gameId);

        $this->user()->removeGame($game);

        return redirect()->route('games.show', ['game' => $gameId])
            ->with('success', 'Gra została usunięta z Twojej listy');
    }

    public function rate(RateGame $request)
    {
        $validatedRequest = $request->validated();
        $gameId = (int) $validatedRequest['gameId'];
        $rate = $validatedRequest['rate'] ? (int)$validatedRequest['rate'] : null;
        $game = $this->repository->get($gameId);

        $this->user()->rateGame($game, $rate);

        return redirect()->route('me.games.list', ['games' => $this->user()->games()->paginate()])
            ->with('success', 'Gra została oceniona');
    }

    private function user(): User
    {
        return Auth::user();
    }
}
