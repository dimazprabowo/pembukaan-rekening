<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        if($request->has('invalid'))
        {
            return view('auth.index')->withErrors(['error' => 'Silahkan Login Terlebih Dahulu']);
        } else {
            return view('auth.index');
        }
    }

    public function validateLogin(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $user = auth()->user()->load('roles');
            session(['role' => $user->roles->role_name]);
            return redirect()->route('dashboard');
        } else {
            return view('auth.index')->withErrors(['error' => ['Login Gagal', 'Silahkan Hubungi Administrator']]);
        }
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect()->route('auth');
    }
}
