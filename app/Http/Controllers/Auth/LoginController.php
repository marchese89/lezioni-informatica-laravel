<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Utility\Carrello;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        if (Auth::guard('web')->attempt($credentials)) {

            $request->session()->regenerate();

            if($request->user()->role === 'admin'){
                return redirect('dashboard-admin');
            }elseif($request->user()->role === 'student'){
                Session::put('carrello',new Carrello());
                return redirect('dashboard-studente');
            }


        }

        return back()->withErrors([
            'email' => 'Credenziali non corrette',
        ])->onlyInput('email');


    }
}
