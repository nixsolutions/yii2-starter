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
        $this->delete('auth_assignment', ['user_id' => '1']);
    }
}
