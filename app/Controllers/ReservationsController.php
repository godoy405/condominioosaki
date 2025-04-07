<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\AreaModel;
use App\Validation\ReservationValidation;
use App\Enums\Status;

class ReservationsController extends BaseController
{
    private ReservationModel $model;

    public function __construct()
    {
        $this->model = new ReservationModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gerenciar reservas',
            'reservations' => $this->model->all()
        ];

        return view('Reservations/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Criar nova reserva',
            'reservation' => new ReservationValidation(),
            'areas' => model(AreaModel::class)->orderBy('name', 'ASC')->findAll(),
            'route' => route_to('reservations.create'),
        ];

        return view('Reservations/form', $data);
    }

    public function create()
    {
        $validation = new ReservationValidation();
        $validation->withRequest($this->request);

        if (!$validation->run()) {
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->withInput();
        }

        $data = $this->request->getPost();

        try {
            $this->model->insert($data);

            return redirect()->to(route_to('reservations'))
                ->with('success', 'Reserva criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar a reserva. Tente novamente.')
                ->withInput();
        }
    }

    public function show(string $code)
    {
        $reservation = $this->model->getByCode($code, ['resident', 'area']);

        $data = [
            'title' => 'Detalhes da reserva',
            'reservation' => $reservation
        ];

        return view('Reservations/show', $data);
    }

    public function edit(string $code)
    {
        $reservation = $this->model->getByCode($code);

        $data = [
            'title' => 'Editar reserva',
            'reservation' => $reservation,
            'validation' => new ReservationValidation()
        ];

        return view('Reservations/form', $data);
    }

    public function update(string $code)
    {
        $validation = new ReservationValidation();
        $validation->withRequest($this->request);

        if (!$validation->run()) {
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->withInput();
        }

        $data = $this->request->getPost();

        try {
            $this->model->update($code, $data);

            return redirect()->to(route_to('reservations'))
                ->with('success', 'Reserva atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar a reserva. Tente novamente.')
                ->withInput();
        }
    }

    public function destroy(string $code)
    {
        try {
            $this->model->delete($code);

            return redirect()->to(route_to('reservations'))
                ->with('success', 'Reserva excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir a reserva. Tente novamente.');
        }
    }

    public function approve(string $code)
    {
        try {
            $this->model->markAs($code, Status::Approved);

            return redirect()->to(route_to('reservations'))
                ->with('success', 'Reserva aprovada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao aprovar a reserva. Tente novamente.');
        }
    }

    public function reject(string $code)
    {
        try {
            $this->model->markAs($code, Status::Rejected);

            return redirect()->to(route_to('reservations'))
                ->with('success', 'Reserva rejeitada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao rejeitar a reserva. Tente novamente.');
        }
    }

    public function manage()
    {
        $residentId = auth()->user()->id;
        
        $data = [
            'title' => 'Gerenciar Minhas Reservas',
            'reservations' => $this->model->where('resident_id', $residentId)->findAll(),
            'areas' => model(AreaModel::class)->orderBy('name', 'ASC')->findAll()
        ];
    
        return view('Resident/reservations_manage', $data);
    }
}