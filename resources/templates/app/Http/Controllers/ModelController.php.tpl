<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Semge\Laravel\BaseControllerTrait;
use App\Http\Requests\CasaRequest;

class [Model]Controller extends Controller
{
    use BaseControllerTrait;

    protected $repositoryClass = \App\Repositories\[Model]Repository::class;
}
