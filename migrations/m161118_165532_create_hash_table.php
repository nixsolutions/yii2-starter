<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hash`.
 */
class m161118_165532_create_hash_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hash', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'hash' => $this->string(),
            'type' => "ENUM('register','recover') DEFAULT 'register'"
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hash');
    }
}
