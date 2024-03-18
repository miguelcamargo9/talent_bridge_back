<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeUsernameUnique extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('users', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
    }
}
