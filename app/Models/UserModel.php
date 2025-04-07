<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $returnType = 'object';
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'status',
    ];

    public function isBanned($userId)
    {
        $user = $this->find($userId);
        return isset($user->status) && $user->status === 'banned';
    }

    public function unbanUser($userId)
    {
        return $this->update($userId, [
            'status' => 'active'
        ]);
    }
}