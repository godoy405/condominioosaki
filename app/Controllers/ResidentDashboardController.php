<?php

namespace App\Controllers;

class ResidentDashboardController extends BaseController
{
    public function index()
    {
        return view('Resident/dashboard');
    }

    public function manage()
    {
        return view('Resident/reservations/manage');
    }
}