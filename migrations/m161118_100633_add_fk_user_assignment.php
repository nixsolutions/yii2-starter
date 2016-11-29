<?php

use yii\db\Migration;

class m161118_100633_add_fk_user_assignment extends Migration
{
    public function up()
    {
        $this->alterColumn('auth_assignment', 'user_id', 'integer');
        $this->addForeignKey('fk_user_id', 'auth_assignment', 'user_id', 'users', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_id', 'auth_assignment');
        $this->alterColumn('auth_assignment', 'user_id', 'string');
    }
}
