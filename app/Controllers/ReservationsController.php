<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservationModel;

class ReservationsController extends BaseController
{

    private ReservationModel $model;

    public function __construct()
    {
        $this->model = model(ReservationModel::class);
    }
    /**
     * @return string
     */


    public function index()
    {
        
        $data = [
            'title'        => 'Gerenciar reservas',
            'reservations' => $this->model->all(),
        ];

        return view('reservations/index', $data);
    }
}
