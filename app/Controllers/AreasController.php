<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Area;
use App\Models\ResidentModel;
use App\Validation\AreaValidation;
use CodeIgniter\HTTP\RedirectResponse;
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

    public function new()
    {     
                      
        $data = [
            'title'    => 'Nova área de lazer',
            'area'     => new Area(),
            'route'    => route_to('areas.create'),          
        ];
      

        return view('Areas/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = (new AreaValidation)->getRules();

        if ( ! $this->validate($rules) ){
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $area = new Area($this->validator->getValidated());
        $id = $this->model->insert($area);
        $area = $this->model->find($id);

        return redirect()->route('areas.show', [$area->code])->with('success', 'Sucesso !');                          
                             
    }

    public function show(string $code)
    {     
        $area = $this->model->getByCode(code : $code);
                      
        $data = [
            'title'    => 'Detalhes da área',
            'area'     => $area,                  
        ];
      

        return view('Areas/show', $data);
    }
}
