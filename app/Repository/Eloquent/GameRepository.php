<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\Game;
use App\Repository\GameRepository as GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
{
    private Game $gameModel;

    public function __construct(Game $model)
    {
        $this->gameModel = $model;
    }

    public function get(int $id)
    {
        return $this->gameModel->find($id);
    }

    public function all()
    {
        return $this->gameModel->with('genre')
            ->orderBy('created_at')->get();
    }

    public function allPaginated(int $itemsPerPage)
    {
        return $this->gameModel->with('genre')
            ->orderBy('created_at')
            ->paginate($itemsPerPage);
    }

    public function best()
    {
        return $this->gameModel->best()->get();
    }

    public function stats()
    {
        return [
            'count' => $this->gameModel->count(),
            'countScoreGt7' => $this->gameModel->where('score', '>', 7)->count(),
            'max' => $this->gameModel->max('score'),
            'min' => $this->gameModel->min('score'),
            'avg' => $this->gameModel->avg('score')
        ];
    }

    public function scoreStats()
    {
        return $this->gameModel
            ->select(
                'score',
                $this->gameModel->raw('count(*) as count')
            )
            ->groupBy('score')
            ->having('count', '>=', 10)
            ->orderBy('count', 'desc')
            ->get();
    }
}
