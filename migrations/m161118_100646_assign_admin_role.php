<?php

use yii\db\Migration;

class m161118_100646_assign_admin_role extends Migration
{
    public function up()
    {
        $this->insert('auth_assignment',[
            'item_name' => 'admin',
            'user_id' => '1',
        ]);
    }

    public function down()
    {
        echo "m161118_100646_assign_admin_role cannot be reverted.\n";

        return false;
    }
}
