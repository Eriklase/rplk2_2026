<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::guard('user')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect()->intended('/admin');
        }else{
            return redirect(route('auth.index'))->with('pesan','Email atau Password Salah');
        }
    }
    public function logout()
    {

    }
}
