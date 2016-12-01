<?php

use yii\db\Migration;

class m161201_164506_add_hash_for_admin extends Migration
{
    public function up()
    {
        $this->insert('hashes', [
            'id' => 1,
            'user_id' => 1,
            'hash' => Yii::$app->security->generateRandomString(),
            'type' => 'register'
        ]);
    }

    public function down()
    {
        $this->delete('hashes', ['user_id' => 1]);
    }

}
