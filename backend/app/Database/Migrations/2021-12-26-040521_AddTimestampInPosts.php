<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampInPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn("posts", [
            "createdAt datetime default current_timestamp",
            "updatedAt datetime default current_timestamp on update current_timestamp",
        ]);
    }

    public function down()
    {
        //
    }
}
