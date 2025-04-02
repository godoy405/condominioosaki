<?php
// cSpell:disable
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Area;
use App\Models\AreaModel;
use App\Validation\AreaValidation;
use CodeIgniter\HTTP\RedirectResponse;

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
            'title'     => 'Gerenciar áreas',
            'areas'     => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('Areas/index', $data);
    }

    public function new()
    {     
        $data = [
            'title'    => 'Nova área',
            'area'     => new Area(),
            'route'    => route_to('areas.create'),          
        ];

        return view('Areas/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = (new AreaValidation)->getRules();

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Por favor, corrija os erros abaixo.');
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        try {
            $area = new Area($this->validator->getValidated());
            $id = $this->model->insert($area);
            $area = $this->model->find($id);

            return redirect()->route('areas.show', [$area->code])
                           ->with('success', 'Área cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao cadastrar área. ' . $e->getMessage());
        }
    }

    public function show(string $code)
    {     
        $area = $this->model->getByCode(code: $code);
        
        $data = [
            'title'    => 'Detalhes da área',
            'area'     => $area,
        ];

        return view('Areas/show', $data);
    }

    public function edit(string $code)
    {     
        $area = $this->model->getByCode(code: $code);
        
        $data = [
            'title'    => 'Editar área',
            'area'     => $area,
            'route'    => route_to('areas.update', $area->code),
            'hidden'   => ['_method' =>'PUT']
        ];

        return view('Areas/form', $data);
    }

    public function update(string $code): RedirectResponse 
    {
        $rules = (new AreaValidation)->getRules(code: $code);

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Por favor, corrija os erros abaixo.');
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        try {
            $area = $this->model->getByCode(code: $code);
            $area->fill($this->validator->getValidated());
            $this->model->save($area);

            return redirect()->route('areas.show', [$area->code])
                           ->with('success', 'Área atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao atualizar área. ' . $e->getMessage());
        }
    }

    public function destroy(string $code): RedirectResponse 
    {        
        $this->model->where('code', $code)->delete();

        return redirect()->route('areas')->with('success', 'Área excluída com sucesso!');                          
    }
}
