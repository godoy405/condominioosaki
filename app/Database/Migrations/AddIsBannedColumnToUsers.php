<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsBannedColumnToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'is_banned' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'is_banned');
    }
}