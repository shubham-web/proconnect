<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMeta extends Migration
{
    public function up()
    {
        $this->forge->addField("id");
        $this->forge->addField([
            "userId" => [
                "type" => "INT",
                "constraint" => 9,
            ],
            "dp" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => true,
            ],
            "profileHeader" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => true,
            ],
            "experience" => [
                "type" => "TEXT",
                "null" => true,
            ],
            "education" => [
                "type" => "TEXT",
                "null" => true,
            ],
            "profileViews" => [
                "type" => "INT",
                "constraint" => 9,
                "default" => 0,
            ]
        ]);

        $this->forge->createTable("UserMeta");
    }

    public function down()
    {
        $this->forge->dropTable("UserMeta");
    }
}
