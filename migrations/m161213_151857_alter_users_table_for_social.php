<?php

use yii\db\Migration;

class m161213_151857_alter_users_table_for_social extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'auth_provider', 'string');
        $this->addColumn('users', 'social_id', 'string');
    }

    public function down()
    {
        $this->dropColumn('users', 'auth_provider');
        $this->dropColumn('users', 'social_id');
    }
}
