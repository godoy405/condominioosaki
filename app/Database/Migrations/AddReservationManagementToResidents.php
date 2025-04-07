<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReservationManagementToResidents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('residents', [
            'can_manage_reservations' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('residents', 'can_manage_reservations');
    }
}