<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proovedores;
use App\Http\Requests\ValidacionABMproovedores;
use Yajra\Datatables\Facades\Datatables;

class ABM_proovedores extends Controller
{
    
  public function index()
  {
    
    return view('ABM_proovedores');
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

    public function datos()
    {
        return Datatables::eloquent(Proovedores::query())->make(true);
    }

    public function traerRelacion()
    {
        return Proovedores::all();
    }
}
