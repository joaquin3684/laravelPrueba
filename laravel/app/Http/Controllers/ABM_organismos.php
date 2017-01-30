<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organismos as Organismos;
use App\Http\Requests\ValidacionABMorganismos;

class ABM_organismos extends Controller
{
    
    public function index()
    {   
        $registros = Organismos::all();
        return view('ABM_organismos', compact('registros'));
        
    }

 
    public function store(ValidacionABMorganismos $request)
    {   
        Organismos::create($request->all());
        $registros = Organismos::all();
        return compact('registros');
    }

    public function show($id)
    {
        $registro = Organismos::find($id);
        return $registro;
       
    }

    public function update(ValidacionABMorganismos $request, $id)
    {
        $registro = Organismos::find($id);
        $registro->fill($request->all())->save();
    }


    public function destroy($id)
    {
        $registro = Organismos::find($id);
        $registro->delete();
    }

    public function traerRelacionorganismos()
    {
        return  Organismos::all();
    }

}
