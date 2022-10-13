<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('users',[
            'title' => 'E-commerce resmi CV. SARANA PRIMA LESTARI | All Products',
            'active' => 'Home',
			"users" => User::all()
		]);
    }
}
