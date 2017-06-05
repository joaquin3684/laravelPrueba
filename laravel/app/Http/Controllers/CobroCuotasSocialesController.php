<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CobroCuotasSocialesController extends Controller
{
    public function index()
    {
        return view('cobro_cuotas_sociales');
    }

    public function cobrar(Request $request)
    {

    }
}
