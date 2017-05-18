<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidacionABMorganismos;
use App\Repositories\Eloquent\ABMS\AbmOrganismosRepositorio as Organismo;

class ABM_organismos extends Controller
{

    private $organismo;
    public function __construct(Organismo $organismo)
    {
        $this->organismo = $organismo;
    }

    public function index()
    {   
        $registros = $this->organismo->all();
        return view('ABM_organismos', compact('registros'));
        
    }

 
    public function store(ValidacionABMorganismos $request)
    {
        $this->organismo->store($request->all());

    }

    public function show($id)
    {
        return $this->organismo->show($id);
       
    }

    public function update(ValidacionABMorganismos $request, $id)
    {
        $this->organismo->update($request->all(), $id);
    }


    public function destroy($id)
    {
        $this->organismo->destroy($id);
    }

    public function traerRelacionorganismos()
    {
        return  $this->organismo->all();
    }

}
