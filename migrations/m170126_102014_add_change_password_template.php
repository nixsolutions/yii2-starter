<?php

use yii\db\Migration;

class m170126_102014_add_change_password_template extends Migration
{
    public function up()
    {
        $this->insert('mail_templates', [
            'key' => 'CHANGE_PASSWORD',
            'body' => '<p>Hello, {{name}}!</p>'
                . '<p>To change your password, click here please {{link}}.</p>',
            'updated_at' => date('Y-m-d H:i:s'),
            'name' => 'Password changing',
            'subject' => 'Password changing'
        ]);
    }

    public function down()
    {
        $this->delete('mail_templates', ['key' => 'CHANGE_PASSWORD']);
    }
}
