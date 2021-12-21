<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField("id"); // will also create it primary key and
        $this->forge->addField([
            "firstName" => [
                "type" => "VARCHAR",
                "constraint" => 100
            ],
            "lastName" => [
                "type" => "VARCHAR",
                "constraint" => 100
            ],
            "country" => [
                "type" => "INT",
                "constraint" => 4,
            ],
            "email" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "unique" => true,
            ],
            "mobile" => [
                "type" => "BIGINT",
                "constraint" => 15
            ],
            "password" => [
                "type" => "TEXT",
            ],
            "status" => [
                "type" => "ENUM",
                "constraint" => ["VERIFIED", "UNVERIFIED", "SUSPENDED"],
                "default" => "VERIFIED",
                "null" => false,
            ],
            "dob" => [
                "type" => "DATE",
                "null" => true,
            ],
            "createdAt datetime default current_timestamp",
            "updatedAt datetime default current_timestamp on update current_timestamp"
        ]);
        $this->forge->createTable("Users");
    }

    public function down()
    {
        $this->forge->dropTable("Users");
    }
}
