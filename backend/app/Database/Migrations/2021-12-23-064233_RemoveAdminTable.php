<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveAdminTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable("admins");
    }

    public function down()
    {
        //
    }
}
