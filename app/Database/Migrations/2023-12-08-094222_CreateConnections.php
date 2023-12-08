<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class CreateConnections extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'follower_user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'following_user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('follower_user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('following_user_id', 'users', 'id', '', 'CASCADE');

        $this->forge->createTable('connections');
    }

    public function down()
    {
        $this->forge->dropTable('connections', true);
    }
}
