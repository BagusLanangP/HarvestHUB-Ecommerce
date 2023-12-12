<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index'); 
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'phone' => 'required|unique:users|min:12|max:12',
            'password' => 'required|min:8|max:255'
        ]);
        User::create($validateData);

        return redirect('/login')->with('success',  'Registration succesfuly!, Please Login');
    }
}
