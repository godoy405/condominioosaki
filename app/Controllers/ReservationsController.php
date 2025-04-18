<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservationModel;
use App\Validation\ReservationValidation;
use CodeIgniter\HTTP\RedirectResponse;
use App\Entities\Reservation;
use App\Models\AreaModel;

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

    public function new()
    {
        
        $data = [
            'title'       => 'Criar nova reserva',
            'reservation' => new Reservation(),
            'areas'        => model(AreaModel::class)->orderBy('name', 'ASC')->findAll(),
            'route'       => route_to('reservations.create'),
        ];

        return view('reservations/form', $data);
    }

    public function create(): RedirectResponse 
    {
        $rules = (new ReservationValidation)->getRules();

        if ( ! $this->validate($rules) ){
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $reservation = new Reservation($this->validator->getValidated());
        $id = $this->model->insert($reservation);
        $reservation = $this->model->find($id);

        // TODO: notificar síndico que tem nova reserva

        return redirect()->route('reservations.show', [$reservation->code])->with('success', 'Sucesso !');                          
                             
    }

    public function show(string $code)
    {
        
        $reservation= $this->model->getByCode(code : $code, contains: ['resident', 'bill', 'area']);

        $data = [
            'title'       => 'Criar nova reserva',
            'reservation' => new Reservation(),
            'areas'        => model(AreaModel::class)->orderBy('name', 'ASC')->findAll(),
            'route'       => route_to('reservations.create'),
        ];

        return view('reservations/form', $data);
    }


}
