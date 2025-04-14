<?php

namespace App\Entities;

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
}
