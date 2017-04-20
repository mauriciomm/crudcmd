<?php

namespace App\Repositories;

use Semge\Laravel\Repository;

class [Model]Repository extends Repository
{
    protected $modelClass = \App\Models\[Model]::class;

    public function getDataForDataTable() {
        $[Model] = $this->newQuery()
            ->select(
            	'id',
                'descricao'
            );
        return $[Model];
    }
}
