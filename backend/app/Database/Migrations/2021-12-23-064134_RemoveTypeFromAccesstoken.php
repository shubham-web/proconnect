<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTypeFromAccesstoken extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("AccessTokens", "type");
    }

    public function down()
    {
        //
    }
}
