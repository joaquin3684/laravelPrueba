<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class Login extends Controller
{
	public function index()
	{
		return view('login');
	}    

	public function login(Request $request)
	{
		$pum = Sentinel::authenticate($request->all());
		if(Sentinel::check())
		{
			return redirect('/asociados');
		} else {
			return ['mierda' => 'caca'];
		}
		return Sentinel::check();
	}

	public function logout()
	{
		Sentinel::logout();
		return redirect('/login');
	}
}
