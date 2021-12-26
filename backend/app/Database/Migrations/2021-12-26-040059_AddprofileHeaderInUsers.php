<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddprofileHeaderInUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn("users", [
            "profileHeader" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => true,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
