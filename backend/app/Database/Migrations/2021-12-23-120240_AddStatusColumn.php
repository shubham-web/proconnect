<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn("Posts", [
            "status" => [
                "type" => "ENUM",
                "constraint" => ["ACTIVE", "SUSPENDED"],
                "default" => "ACTIVE",
                "null" => false,
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
