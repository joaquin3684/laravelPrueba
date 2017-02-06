<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proovedores;
use App\Http\Requests\ValidacionABMproovedores;

class ABM_proovedores extends Controller
{
    
  public function index()
  {
    $registros = Proovedores::all();
    return view('ABM_proovedores', compact('registros'));
  }

   public function store(ValidacionABMproovedores $request)
    {   
        Proovedores::create($request->all());
        $registros = Proovedores::all();
        return ['created' => true];
    }

    public function show($id)
    {
        $registro = Proovedores::find($id);
        return $registro;
       
    }

    public function update(ValidacionABMproovedores $request, $id)
    {
        $registro = Proovedores::find($id);
        $registro->fill($request->all())->save();
        return ['updated' => true];
    }


    public function destroy($id)
    {
        $registro = Proovedores::find($id);
        $registro->delete();
        return ['deleted' => true];
    }

}
