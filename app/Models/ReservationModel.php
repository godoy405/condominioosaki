<?php
// cSpell:disable
namespace App\Models;

use App\Entities\Reservation;
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

    public function setInitialData(array $data): array
    {
       return $data;
    }

    protected function relateData(object &$area, array $contains = []): void
    {
        if(in_array('reservations', $contains)) {
           //TODO: Recuperar as reservas que cada área possui.
        }
    }

}
