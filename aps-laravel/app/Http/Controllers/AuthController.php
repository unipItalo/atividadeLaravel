<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Credenciais fixas para demonstração
        $validEmail = 'admin@example.com';
        $validPassword = '123456';

        if ($request->email === $validEmail && $request->password === $validPassword) {
            session(['user' => [
                'email' => $request->email,
                'name' => 'Administrador',
                'logged_in' => true
            ]]);

            // Cookie de lembrar usuário
            if ($request->has('remember')) {
                return redirect()->route('produtos.index')
                    ->with('success', 'Login realizado com sucesso!')
                    ->cookie('user_email', $request->email, 60*24*30); // 30 dias
            }

            return redirect()->route('produtos.index')
                ->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!')
            ->cookie('user_email', null, -1); // Remove cookie
    }
}