<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        $forge = $this->forge;

        // --
        $forge->addField([
            'id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'display_name' => ['type' => 'varchar', 'constraint' => 30],
            'avatar'       => ['type' => 'varchar', 'constraint' => 64, 'null' => true],
        ])
            ->addKey('id', true)
            ->addForeignKey('id', 'users', 'id', '', 'CASCADE')
            ->createTable('profiles');

        // ---

        $forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'follower_user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'following_user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
        ])
            ->addKey('id', true)
            ->addForeignKey('follower_user_id', 'users', 'id', '', 'CASCADE')
            ->addForeignKey('following_user_id', 'users', 'id', '', 'CASCADE')
            ->createTable('connections');

        // ---

        $forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'parent_status_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'content'          => ['type' => 'varchar', 'constraint' => 280, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ])
            ->addKey('id', true)
            ->addForeignKey('user_id', 'users', 'id', '', 'CASCADE')
            ->addForeignKey('parent_status_id', 'status', 'id', '', 'CASCADE')
            ->createTable('status');

        // ---
    }

    public function down()
    {
        $forge = $this->forge;

        $forge->dropTable('profiles', true);
        $forge->dropTable('connections', true);
        $forge->dropTable('status', true);
    }
}
