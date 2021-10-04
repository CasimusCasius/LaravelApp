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
        return $this->gameModel->with('genres')
            ->orderBy('created_at')->get();
    }

    public function allPaginated(int $itemsPerPage)
    {
        return $this->gameModel->with('genres')
            ->orderBy('created_at')
            ->paginate($itemsPerPage);
    }

    public function filterBy(?string $phrase, string $type = self::TYPE_DEFAULT, int $itemsPerPage = 15)
    {
        $query = $this->gameModel->with('genres')
            ->orderBy('created_at');

        if (!in_array($type, self::USABLE_TYPES))
        {
            $type = self::TYPE_DEFAULT;
        }

        if ($type !== self::TYPE_ALL)
        {
            $query->where('type', $type);
        }


        if ($phrase)
        {
            $query->where('name', 'like', '%' . $phrase . '%');
        }
        return $query->paginate($itemsPerPage);
    }

    public function best()
    {
        return $this->gameModel->with('genres')->best()->get();
    }

    public function stats()
    {
        return [
            'count' => $this->gameModel->count(),
            'countScoreGt7' => $this->gameModel->where('metacritic_score', '>=', 70)->count(),
            'max' => $this->gameModel->max('metacritic_score'),
            'min' => $this->gameModel->min('metacritic_score'),
            'avg' => $this->gameModel->avg('metacritic_score')
        ];
    }

    public function scoreStats()
    {
        $result = $this->gameModel
            ->select(
                'metacritic_score',
                $this->gameModel->raw('count(*) as count')
            )->whereNotNull('metacritic_score')
            ->groupBy('metacritic_score')
            ->having('count', '>=', 80)
            ->orderBy('count', 'desc')
            ->get();

        return $result;
    }
}
