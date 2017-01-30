<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Socios as Socios;
use App\Http\Requests\ValidacionABMsocios;

class ABM_asociados extends Controller
{
    public function index()
    {   
        $registros = Socios::all();
        return view('ABM_socios', compact('registros'));
    }
    
    public function store(ValidacionABMsocios $request)
    {   
        
        Socios::create($request->all());
        $registros = Socios::all();
        return compact('registros');
    }

    public function show($id)
    {
        $registro = Socios::find($id);
        return $registro;
       
    }

    public function update(ValidacionABMsocios $request, $id)
    {
        $registro = Socios::find($id);
        $registro->fill($request->all())->save();
    }


    public function destroy($id)
    {
        $registro = Socios::find($id);
        $registro->delete();
    }

    public function traerDatos()
    {
        return Socios::all();
    }
}
