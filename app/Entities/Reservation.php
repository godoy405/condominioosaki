<?php

namespace App\Entities;

use App\Enum\Reservation\Status;
use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;

class Reservation extends Entity
{
   
    use ResidentFilterTrait;

    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'            => '?integer',
        'area_id'       => '?integer',  
        'resident_id'   => '?integer',              
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


}
