<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hash`.
 */
class m161118_165532_create_hashes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hashes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'hash' => $this->string(),
            'type' => "ENUM('register','recover') DEFAULT 'register'"
        ]);

        $this->addForeignKey('fk_user_id', 'hashes', 'user_id', 'users', 'id', 'cascade', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hashes');
    }
}
