<?php

use yii\db\Migration;

class m170127_102137_add_hash_type extends Migration
{
    public function up()
    {
        $this->alterColumn('hashes', 'type', "ENUM('register','recover','change password') DEFAULT 'register'");
    }

    public function down()
    {
        $this->alterColumn('hashes', 'type', "ENUM('register','recover') DEFAULT 'register'");
    }
}
