<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ResidentModel;

class ResidentAuthController extends Controller
{
    protected $residentModel;
    protected $request;

    public function __construct()
    {
        $this->residentModel = new ResidentModel();
        $this->request = \Config\Services::request();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Busca o residente pelo email
            $resident = $this->residentModel->where('email', $email)
                                          ->with(['user'])
                                          ->first();

            if ($resident && $resident->hasUser()) {
                // Verifica se o usuário está bloqueado
                if ($resident->user->isBanned()) {
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', 'Sua conta está temporariamente bloqueada. Procure o síndico');
                }

                // Verifica a senha
                if (password_verify($password, $resident->password)) {
                    $session = session();
                    $session->set([
                        'resident_id' => $resident->id,
                        'resident_name' => $resident->name,
                        'resident_email' => $resident->email,
                        'resident_logged_in' => true
                    ]);

                    return redirect()->to('/resident/dashboard')
                                   ->with('success', 'Bem-vindo(a) ' . $resident->name);
                }
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Email ou senha inválidos');
        }

        return view('Auth/login');
    }

    public function logout()
    {
        $session = session();
        $session->remove(['resident_id', 'resident_name', 'resident_email', 'resident_logged_in']);
        return redirect()->to('/login')->with('success', 'Você saiu do sistema');
    }
} 