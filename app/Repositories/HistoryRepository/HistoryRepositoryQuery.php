<?php

namespace App\Repositories\HistoryRepository;

use Illuminate\Database\Eloquent\Builder;

class HistoryRepositoryQuery
{
    public Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
