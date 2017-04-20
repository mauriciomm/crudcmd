<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Semge\Laravel\BaseControllerTrait;
use App\Http\Requests\CasaRequest;

use Datatables;

class [Model]Controller extends Controller
{
    use BaseControllerTrait;

    protected $repositoryClass = \App\Repositories\[Model]Repository::class;

    /**
    * Process datatables ajax request.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function anyData()
    {
    	$[Model] = $this->repository->getDataForDataTable();

    	return Datatables::of($[Model])
        ->addColumn('acoes', function($[Model]) {
            return '<a href="'.route('[tablename].edit', [$[Model]->id]).'" class="btn btn-default">Editar</a>
            <a href="'.route('[tablename].update', [$[Model]->id]).'" class="btn btn-default">
            '.(($[Model]->ativo == 's') ? 'Desativar' :'Ativar').'
            </a>';
        })
        ->rawColumns(['acoes'])
        ->removeColumn('id')
        ->make(true);
    }
}
