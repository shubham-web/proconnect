<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountry extends Migration
{
    public function up()
    {
        $this->forge->addField("id");
        $this->forge->addField([
            "name" => [
                "type" => "VARCHAR",
                "CONSTRAINT" => 255,
            ]
        ]);
        $this->forge->createTable("Countries");
    }

    public function down()
    {
        $this->forge->dropTable("Countries");
    }
}
