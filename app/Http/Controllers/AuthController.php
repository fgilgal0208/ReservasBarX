<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra la pantalla de Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el formulario de Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Intentamos iniciar sesión (usando 'name' en lugar de 'email')
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Si tiene éxito, lo mandamos al calendario
            return redirect()->intended('/');
        }

        // Si falla, lo devolvemos con un error
        return back()->withErrors([
            'name' => 'El usuario o la contraseña son incorrectos.',
        ])->onlyInput('name');
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}