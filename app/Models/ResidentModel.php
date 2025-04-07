<?php
// cSpell:disable
namespace App\Models;

use App\Entities\Resident;
use App\Models\Basic\AppModel;
use Exception;

class ResidentModel extends AppModel
{
    protected $table            = 'residents';    
    protected $returnType       = Resident::class;   
    protected $allowedFields    = [
        'user_id',
        'name',
        'apartment',
        'mobile_phone',
        'code',
        'can_manage_reservations' // Add this field
    ];

    protected $beforeInsert = ['generateCode'];
    protected $contains = [];

    protected function generateCode(array $data): array
    {
        if (!isset($data['data']['code'])) {
            $data['data']['code'] = random_int(10000000, 99999999);
        }
        return $data;
    }

    public function getLoggedResident(): Resident{
        $resident = $this->where('id', auth()->user()->residente_id)->first();

        if(!$resident) {
            throw new Exception("Residente associado ao usuário logado não foi encontrado", EXIT_ERROR);
        }
        return $resident;
    }

    protected function relateData(object &$resident, array $contains = []): void
    {
        if(in_array('user', $contains)) {
            if ($resident->user_id !== null) {
                $userModel = auth()->getProvider();
                $resident->user = $userModel->find($resident->user_id);
                
                if ($resident->user) {
                    try {
                        $resident->user->isBanned = $userModel->isBanned($resident->user->id);
                    } catch (\Exception $e) {
                        $resident->user->isBanned = false; // Default to false if there's an error
                    }
                }
            } else {
                $resident->user = null;
            }
        }
    }

    /**
     * Carrega os relacionamentos especificados
     * 
     * @param array $relations
     * @return self
     */
    public function with(array $relations): self
    {
        $this->contains = $relations;
        return $this;
    }

    public function canManageReservations($residentId): bool
    {
        $resident = $this->find($residentId);
        return $resident && $resident->can_manage_reservations;
    }
}
