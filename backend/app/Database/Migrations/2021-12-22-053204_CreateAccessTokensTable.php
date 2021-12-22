<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccessTokensTable extends Migration
{
    public function up()
    {
        $this->forge->addField("id");
        $this->forge->addField([
            "type" => [
                "type" => "ENUM",
                "constraint" => ["USER_AUTH", "ADMIN_AUTH"],
                "default" => "USER_AUTH",
                "null" => false,
            ],
            "token" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "targetUser" => [
                "type" => "INT",
                "constraint" => 9,
            ],
            "lastUsedAt datetime default current_timestamp",
            "createdAt datetime default current_timestamp",
        ]);
        $this->forge->createTable("AccessTokens");
    }

    public function down()
    {
        //
        $this->forge->dropTable("AccessTokens");
    }
}
