<?php

use yii\db\Migration;

class m161122_093935_create_admin_user extends Migration
{
    public function up()
    {
        $this->insert('users', [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Yii::$app->security->generatePasswordHash('123456'),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'last_login_at' => date('Y-m-d H:i:s'),
            'auth_key' => Yii::$app->security->generateRandomString(),
        ]);
    }

    public function down()
    {
        $this->delete('users', ['id' => '1']);
    }
}