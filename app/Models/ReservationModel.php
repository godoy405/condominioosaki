<?php
// cSpell:disable
namespace App\Models;


use Exception;
use App\Enum\Reservation\Status;
use App\Entities\Reservation;
use App\Models\Basic\AppModel;
use App\Traits\Models\ResidentFilterTrait;
use App\Models\BillModel;


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
        $data['data'] ['status']        = Status::PENDING->value;
        $data['data'] ['reason_status'] = Status::PENDING->label();
        $data['data'] ['resident_id']   = auth()->user()->resident->id ?? null;

        return $data;
       
    }

    public function all(): array 
    {

        $this->whereResident();

        $this->select([
            'reservations.*',
            'areas.name As area',
        ]);

        $this->join('areas', 'areas.id = reservations.area_id');

        $this->orderBy('reservations.created_at', 'DESC');

        return $this->findAll();
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $this->whereResident();

        // Recupera a reserva pelo código
        $reservation = parent::getByCode(code: $code);

        if ($reservation === null) {
            throw new \RuntimeException("Reserva com código {$code} não encontrada");
        }

        // Relaciona dados adicionais, se necessário
        $this->relateData($reservation, $contains);

        return $reservation;
    }
    


    protected function relateData(object &$reservation, array $contains = []): void
    {
        if (in_array('bill', $contains)) {
            try {
                $billModel = class_exists('App\\Models\\BillModel') ? model('App\\Models\\BillModel', false) : null;
                if ($billModel && isset($reservation->id)) {
                    $reservation->bill = $billModel
                        ->where('reservation_id', $reservation->id)
                        ->first();
                } else {
                    $reservation->bill = null;
                }
            } catch (\Throwable $e) {
                $reservation->bill = null;
            }
        }

        if (in_array('resident', $contains)) {
            $reservation->resident = model('App\\Models\\ResidentModel', false)
                ->where('id', $reservation->resident_id)
                ->first();
        }

        if (in_array('area', $contains)) {
            $reservation->area = model('App\\Models\\AreaModel', false)
                ->where('id', $reservation->area_id)
                ->first();
        }
    }

    public function markAs(string $code, Status $status): bool
    {
        try {
            $data = [
                'status' => $status->value,
                'reason_status' => $status->label()
            ];

            $result = $this->set($data)
                          ->where('code', $code)
                          ->update();

            // Adicionando log para debug
            log_message('debug', 'Atualizando status: ' . json_encode([
                'code' => $code,
                'new_status' => $status->value,
                'result' => $result
            ]));

            return (bool) $result;
        } catch (\Exception $e) {
            log_message('error', '[Reserva] Erro ao atualizar status: ' . $e->getMessage());
            return false;
        }
    }

}
