<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIpInAccessToken extends Migration
{
    public function up()
    {
        $this->forge->addColumn("AccessTokens", [
            "ip" => [
                "type" => "VARCHAR",
                "constraint" => "255",
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
