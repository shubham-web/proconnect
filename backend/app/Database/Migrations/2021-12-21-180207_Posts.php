<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField("id");
        $this->forge->addField([
            "userId" => [
                "type" => "INT",
                "constraint" => 9,
            ],
            "text" => [
                "type" => "TEXT",
            ],
            "media" => [
                "type" => "TEXT",
                "null" => true,
            ],
            "likes" => [
                "type" => "INT",
                "constraint" => 9,
                "default" => 0,
            ],
        ]);
        $this->forge->createTable("Posts");
    }

    public function down()
    {
        $this->forge->dropTable("Posts");
    }
}
