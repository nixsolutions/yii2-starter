<?php

use yii\db\Migration;

class m161123_152129_add_register_confirm_template extends Migration
{
    public function up()
    {
        $this->insert('mail_templates', [
            'key' => 'REGISTER',
            'body' => '<p>Hello, {{name}}!</p>'
                . '<p>Thank you for registration! To activate your account, click here please {{link}}.</p>'
                . '<p>After confirmation you will be automatically logged in.</p>',
            'updated_at' => date('Y-m-d H:i:s'),
            'name' => 'Confirm registration',
            'subject' => 'Registration confirmation'
        ]);
    }

    public function down()
    {
        $this->delete('mail_templates', ['key' => 'REGISTER']);
    }
}
