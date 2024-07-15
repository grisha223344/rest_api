<?php

namespace App\Repositories\HistoryRepository;

use App\DTO\StoreHistoryDTO;
use App\Models\History;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Builder;

class HistoryRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return History::class;
    }

    private function setFields($orderBy = 'id', $orderType = 'ASC', $fields = ['model_id', 'model_name', 'before', 'after', 'action']): Builder
    {
        return $this->startConditions()->select($fields)->orderBy($orderBy, $orderType);
    }

    public function create(StoreHistoryDTO $storeData)
    {
        return $this->startConditions()->create((array) $storeData);
    }

}
