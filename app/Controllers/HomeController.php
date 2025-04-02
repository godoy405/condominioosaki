<?php

namespace App\Controllers;

use App\Entities\Resident;
use App\Models\ResidentModel;

class HomeController extends BaseController
{
    public function index(): string
    {

        //$model = model(ReservationModel::class);

        //$resident = $model->getByCode(code: '12345678', contains:['user']);

        //dd($resident);

        $data = [
            'title' => 'Home'
        ];

        return view('Home/index', $data);
    }
}
