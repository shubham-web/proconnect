<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDpAndHeaderfromemta extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("usermeta", "dp");
        $this->forge->dropColumn("usermeta", "profileHeader");
    }

    public function down()
    {
        //
    }
}
