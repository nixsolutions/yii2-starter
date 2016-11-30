<?php

use yii\db\Migration;

class m161130_094719_make_email_unique extends Migration
{
    public function up()
    {
        $this->createIndex('email', 'users', 'email', $unique = true);
    }

    public function down()
    {
        $this->dropIndex('email', 'users');
    }
}
