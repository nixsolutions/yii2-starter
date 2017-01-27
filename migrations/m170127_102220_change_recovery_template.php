<?php

use yii\db\Migration;

class m170127_102220_change_recovery_template extends Migration
{
    public function up()
    {
        $this->delete('mail_templates', ['key' => 'CHANGE_PASSWORD']);

        $this->insert('mail_templates', [
            'key' => 'RECOVERY_PASSWORD',
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
        $this->delete('mail_templates', ['key' => 'RECOVERY_PASSWORD']);

        $this->insert('mail_templates', [
            'key' => 'CHANGE_PASSWORD',
            'body' => '<p>Hello, {{name}}!</p>'
                . '<p>To change your password, click here please {{link}}.</p>'
                . '<p>After setting new password you will be automatically logged in.</p>',
            'updated_at' => date('Y-m-d H:i:s'),
            'name' => 'Password recovery',
            'subject' => 'Password recovery'
        ]);
    }
}
