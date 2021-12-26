<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeLikesType extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn("posts", [
            "likes" => [
                "type" => "TEXT",
                "null" => true,
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
