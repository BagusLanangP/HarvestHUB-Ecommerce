<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function authenticating(Request $request){  
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            if (Auth::user()->status === 'banned') {
                Auth::logout();
                Session::flash('status', 'failed');
                Session::flash('message', 'Akun Anda telah dinonaktifkan (Banned).');
                return back()->withInput($request->only('email'));
            }

            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }

        
        Session::flash('status', 'failed');
        Session::flash('message', 'Gagal');

        return back()->withInput($request->only('email'));;

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
