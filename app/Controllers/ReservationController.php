<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReservationController extends BaseController
{
    public function manage()
    {
        return view('Reservation/manage');
    }
}