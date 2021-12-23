<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleInUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn("Users", [
            "role" => [
                "type" => "ENUM",
                "constraint" => ["USER", "ADMIN", "MAINTAINER"],
                "default" => "USER",
                "null" => false,
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
