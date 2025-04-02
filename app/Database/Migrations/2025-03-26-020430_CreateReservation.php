<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservation extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11, 
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'resident_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11, 
                    'unsigned'       => true,
                    'null'           => false,
                    'default'        => null,
                ],                           
                'area_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11, 
                    'unsigned'       => true,
                    'null'           => false,
                ],   
                'code' => [
                    'type'           => 'INT',
                    'constraint'     => 8,                    
                    'null'           => false,                    
                ], 
                'desired_date' => [
                    'type'           => 'DATETIME',                    
                    'comment'        => 'Data e hora desejada para iniciar o uso da área',                                  
                ],                                            
                'status' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 70,                    
                    'null'           => false,                    
                ],
                'reason_status' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 255,                    
                    'comment'        => 'Detalhes do status, etc',                    
                ],
                'notes' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 255,                    
                    'null'           => true, 
                    'default'        => null,                    
                ],                
                'created_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,
                    'default'        => null,                    
                ],
                'updated_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,
                    'default'        => null,                    
                ],
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('resident_id');
        $this->forge->addKey('area_id');
        $this->forge->addKey('code');
        $this->forge->addKey('desired_date');
        $this->forge->addKey('status');       
        $this->forge->addKey('created_at');

        $this->forge->addForeignKey('resident_id', 'residents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('area_id', 'areas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('reservations');
    }

    public function down()
    {
        $this->forge->dropTable('reservations');
    }
}
