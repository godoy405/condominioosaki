<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Area;
use App\Models\AreaModel;

class AreasController extends BaseController
{

    private AreaModel $model;

    public function __construct()
    {
        $this->model = model(AreaModel::class);
    }
    public function index()
    {
        $data = [
            'title' => 'Gerenciar áreas de lazer',
            'areas' => $this->model->orderBy('name', 'ASC')->findAll(),
        ];

        return view('Areas/index', $data);
    }
}
