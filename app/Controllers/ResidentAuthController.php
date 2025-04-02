<?php

namespace App\Controllers;

use App\Controllers\Basic\AppController;
use App\Models\ResidentModel;

class ResidentAuthController extends AppController
{
    private $residentModel;

    public function __construct()
    {
        $this->residentModel = new ResidentModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $mobile_phone = $this->request->getPost('mobile_phone');
            $password = $this->request->getPost('password');

            $resident = $this->residentModel->where('mobile_phone', $mobile_phone)->first();

            if ($resident && password_verify($password, $resident->password)) {
                $session = session();
                $session->set([
                    'resident_id' => $resident->id,
                    'resident_name' => $resident->name,
                    'resident_phone' => $resident->mobile_phone,
                    'resident_logged_in' => true
                ]);

                return redirect()->to('/resident/dashboard')->with('success', 'Bem-vindo(a) ' . $resident->name);
            }

            return redirect()->back()->with('error', 'Telefone ou senha inválidos');
        }

        return view('ResidentAuth/login');
    }

    public function logout()
    {
        $session = session();
        $session->remove(['resident_id', 'resident_name', 'resident_phone', 'resident_logged_in']);
        return redirect()->to('/resident/login')->with('success', 'Você saiu do sistema');
    }
} 