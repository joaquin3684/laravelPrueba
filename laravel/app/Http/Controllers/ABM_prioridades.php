<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\Gateway\PrioridadGateway as Prioridad;

class ABM_prioridades extends Controller
{
    private $prioridad;

    public function __construct(Prioridad $prioridad)
    {
        $this->prioridad = $prioridad;
    }

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
        return $this->prioridad->all();

    }

    public function store(Request $request)
    {
        $this->priorirdad->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->prioridad->find($id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->prioridad->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->prioridad->destroy($id);
    }

    public function traerRelacion()
    {
        return $this->prioridad->all();
    }
}
