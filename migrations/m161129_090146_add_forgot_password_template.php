<?php

use yii\db\Migration;

class m161129_090146_add_forgot_password_template extends Migration
{
    public function up()
    {
        $this->insert('mail_templates', [
            'key' => 'FORGOT_PASSWORD',
            'body' => '<p>Hello, {{name}}!</p>'
                . '<p>To change your password, click here please {{link}}.</p>'
                . '<p>After setting new password you will be automatically logged in.</p>',
            'updated_at' => date('Y-m-d H:i:s'),
            'name' => 'Password recovery',
            'subject' => 'Password recovery'
        ]);
    }

    public function down()
    {
        $this->delete('mail_templates', ['key' => 'FORGOT_PASSWORD']);
    }
}
