<?php

namespace App\Entities;

use App\Enum\Reservation\Status;
use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;

class Reservation extends Entity
{
   
    use ResidentFilterTrait;

    protected $dates   = ['created_at', 'updated_at', 'desired_date'];
    protected $casts   = [
        'id'            => '?integer',
        'area_id'       => '?integer',  
        'resident_id'   => '?integer',              
    ];

    // Campos calculados
    protected $datamap = [
        'area_name' => 'area_name',
        'email' => 'resident_email'
    ];
 
    public function canBeCanceled(): bool
    {
        // Adicionando log para debug
        log_message('debug', 'Status atual: ' . $this->status);
        log_message('debug', 'Comparação: ' . ($this->status === Status::PENDING->value));
        
        // Comparando com o valor do enum
        return $this->status === Status::PENDING->value;
    }

    public function status(): string
    {
        return Status::from($this->status)->label();
    }

    // Método para obter o email do residente
    public function getResidentEmail()
    {
        if (isset($this->attributes['resident_email'])) {
            return $this->attributes['resident_email'];
        }

        if (isset($this->resident) && isset($this->resident->email)) {
            return $this->resident->email;
        }

        return null;
    }
}
