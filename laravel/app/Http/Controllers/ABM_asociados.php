<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMsocios;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway as Socio;

class ABM_asociados extends Controller
{
    private $socio;

    public function __construct(Socio $socio)
    {
        $this->socio = $socio;
    }

    public function index()
    {   
        $registros = $this->socio->all();
        return view('ABM_socios', compact('registros'));
    }

    public function store(ValidacionABMsocios $request)
    {
        $this->socio->create($request->all());
    }

    public function show($id)
    {
        $this->socio->find($id);

    }

    public function traerElementos()
    {
        return $this->socio->all();
    }

    public function update(ValidacionABMsocios $request, $id)
    {
        $this->socio->update($request->all(), $id);
    }

    public function destroy($id)
    {
        $this->socio->destroy($id);
    }

    public function traerDatos()
    {
        return $this->socio->all();
    }
}
