<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prioridades as Prioridades;

class ABM_prioridades extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ABM_prioridades');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datos()
    {
        return Prioridades::all();

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Prioridades::create($request->all());
        return ['created' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registro = Prioridades::find($id);
        return $registro;
    }
    public function guardarConfiguracion(Request $request)
    {

        $i = 1;
        foreach($request->all() as $elemento)
        {

            $e = Prioridades::find($elemento['id']);
            $e->orden = $i;
            $e->save();
            $i++;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $registro = Prioridades::find($id);
        $registro->fill($request->all())->save();
        return ['updated' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registro = Prioridades::find($id);
        $registro->delete();
        return ['deleted' => true];
    }

    public function traerRelacion()
    {
        return Prioridades::all();
    }
}
