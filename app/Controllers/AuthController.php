<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        // Se já estiver logado, redireciona para o dashboard
        if (auth()->loggedIn()) {
            return redirect()->to('/dashboard');
        }

        return view('Auth/login');
    }

    public function attemptLogin()
    {
        $credentials = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password')
        ];

        if (auth()->attempt($credentials)) {
            return redirect()->to('/dashboard')->with('success', 'Bem-vindo(a) ' . auth()->user()->username);
        }

        return redirect()->back()->with('error', 'Email ou senha inválidos');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to('/login')->with('success', 'Você saiu do sistema');
    }
} 