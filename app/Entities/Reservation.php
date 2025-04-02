<?php

namespace App\Entities;

use App\Traits\Entities\ResidentFilterTrait;
use CodeIgniter\Entity\Entity;
use App\Enums\Status;

class Reservation extends Entity
{   

    use ResidentFilterTrait;

    public function __construct()
    {
        parent::__construct();
        $this->beforeInsert = array_merge($this->beforeInsert, ['setInitialData']);
    }

    protected $datamap = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'desired_date'
    ];
    protected $casts = [
        'id' => 'integer',
        'resident_id' => 'integer',
        'area_id' => 'integer',
        'code' => 'integer',
        'status' => Status::class
    ];

    public function isPending(): bool
    {
        return $this->status === Status::Pending->value;
    }

    public function getStatusLabel(): string
    {
        return Status::from($this->status)->label();
    }

    public function getStatusColor(): string
    {
        return Status::from($this->status)->color();
    }
}
