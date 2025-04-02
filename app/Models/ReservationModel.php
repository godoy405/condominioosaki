<?php
// cSpell:disable
namespace App\Models;

use App\Entities\Reservation;
use App\Enums\Status;
use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;


class ReservationModel extends AppModel
{

    use ResidentFilterTrait;

    public function __construct()
    {
        parent::__construct();
        $this->beforeInsert = array_merge($this->beforeInsert, ['setInitialData']);
    }

    protected $table            = 'reservations';    
    protected $returnType       = Reservation::class;   
    protected $allowedFields    = [
        'area_id',
        'resident_id',
        'notes', 
        'status', 
        'reason_status',      
        'desired_date',       
        
    ];

    protected function setInitialData(array $data): array
    {
        $data['data']['status'] = Status::Pending->value;
        $data['data']['reason_status'] = Status::Pending->label();
        $data['data']['resident_id'] = auth()->user()->id;
       //$data['data']['area_id'] = $this->request->getVar('area_id');
       //$data['data']['desired_date'] = $this->request->getVar('desired_date');
       //$data['data']['notes'] = $this->request->getVar('notes');
        return $data;
    }

    public function all(): array
    {
        $this->whereResident();

        $this->select([
            'reservations.*',
            'areas.name AS area_name',           

        ]);

        $this->join('areas', 'areas.id = reservations.area_id');
        $this->orderBy('reservations.created_at', 'DESC');

        return $this->findAll();
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $this->whereResident();

        $reservation = parent::getByCode(code: $code);

        $this->relateData($reservation, $contains);

        return $reservation;
    }
    protected function relateData(object &$reservation, array $contains = []): void
    {
        if(in_array('bill', $contains)) {
            //TODO: buscar a cobrança associada à reserva
            //$reservation->bill =        
        }

        if(in_array('resident', $contains)) {
           $reservation->resident = model(ResidentModel::class)
               ->where('id', $reservation->resident_id)->first();    
        }

        if(in_array('area', $contains)) {
            $reservation->area = model(AreaModel::class)
                ->where('id', $reservation->area_id)->first();
        }
       
    }

    public function markAs(string $code, Status $status): bool {
        $data = [
            'status' => $status->value, 
            'reason_status' => $status->label()
        ];

        return $this->set($data)
            ->where('code', $code)
            ->update();
    }   


}
