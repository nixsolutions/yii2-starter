<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m161118_100631_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->update('users', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string()->unique(),
            'password' => $this->string(),
            'avatar' => $this->string(),
            'status' => "ENUM('created', 'active', 'blocked') DEFAULT 'created'",
            'created_at' => $this->dateTime(),
            'last_login_at' => $this->dateTime(),
            'auth_key' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
