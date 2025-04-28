<?php

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table      = 'bills';
    protected $primaryKey = 'id';
    protected $returnType = \App\Entities\Bill::class;
    protected $allowedFields = [
        'reservation_id',
        'resident_id',
        'code',
        'due_date',
        'status',
        'amount',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}