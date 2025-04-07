<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => 'active',
                'null' => false,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'status');
    }
}