<?php

namespace App\Controllers;

use App\Entities\Resident;
use App\Models\ResidentModel;

class HomeController extends BaseController
{
    public function index(): string
    {

        //$model = model(ResidentModel::class);

        //$resident = $model->getByCode(code: '12345678', contains:['user']);

        //dd($resident);

        $data = [
            'title' => 'Condomínio'
        ];

        return view('Home/index', $data);
    }
}
