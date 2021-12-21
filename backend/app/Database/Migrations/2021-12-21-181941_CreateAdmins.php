<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmins extends Migration
{
    public function up()
    {
        //
        $this->forge->addField("id");
        $this->forge->addField([
            "name" => [
                "type" => "VARCHAR",
                "constraint" => 100
            ],
            "email" => [
                "type" => "VARCHAR",
                "constraint" => 100,
            ],
            "password" => [
                "type" => "TEXT",
            ],
            "lastLogin" => [
                "type" => "datetime",
                "null" => true
            ],
            "createdAt datetime default current_timestamp",
            "updatedAt datetime default current_timestamp on update current_timestamp",
        ]);
        $this->forge->createTable("Admins");
    }

    public function down()
    {
        //
        $this->forge->dropTable("Admins");
    }
}
