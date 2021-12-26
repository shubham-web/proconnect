<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDpInUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn("users", [
            "dp" => [
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
