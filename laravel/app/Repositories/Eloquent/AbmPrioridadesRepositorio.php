<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\RepositorioAbm;

class AbmPrioridadesRepositorio extends RepositorioAbm
{
    function model()
    {
        return 'App\Prioridades';
    }
}