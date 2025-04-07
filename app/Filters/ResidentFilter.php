<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ResidentFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Se não estiver logado como residente, redireciona para o login
        if (!session()->has('resident_logged_in')) {
            return redirect()->to('/login')->with('error', 'Você precisa fazer login como residente para acessar esta área');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer depois
    }
} 