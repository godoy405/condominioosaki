<?php

namespace App\Controllers;

class ReservaController extends BaseController
{
    public function gerenciar()
    {
        return view('Reserva/gerenciar');
    }
}