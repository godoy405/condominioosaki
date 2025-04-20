<?php

namespace App\Controllers;

use App\Services\Notifier\Email;
use App\Controllers\BaseController;
use App\Models\ReservationModel;
use App\Validation\ReservationValidation;
use App\Helpers\app_helper;
use CodeIgniter\HTTP\RedirectResponse;
use App\Entities\Reservation;
use App\Models\AreaModel;
use App\Services\Notifier\Email\NotifierService;


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

        try {
            $syndic = get_syndic();
            $to = $syndic->email;    
            $subject = 'Nova reserva';
            $body = "Nova reserva {$reservation->code} criada com sucesso !";
            
            $notifier = new NotifierService();
            $notifier->send($to, $subject, $body);
            
            return redirect()->route('reservations.show', [$reservation->code])
                            ->with('success', 'Reserva criada com sucesso!');
        } catch (\Exception $e) {
            log_message('error', '[Reserva] Erro ao enviar email: ' . $e->getMessage());
            
            // Ainda redireciona com sucesso, mas com aviso sobre o email
            return redirect()->route('reservations.show', [$reservation->code])
                            ->with('success', 'Reserva criada com sucesso!')
                            ->with('warning', 'Não foi possível enviar o email de notificação.');
        }
    }

    public function show(string $code)
    {
        $reservation = $this->model->getByCode(code: $code, contains: ['resident', 'area']);
        
        $data = [
            'title'       => "Detalhes da Reserva #{$reservation->code}",
            'reservation' => $reservation,
        ];

        return view('reservations/show', $data);
    }


}
