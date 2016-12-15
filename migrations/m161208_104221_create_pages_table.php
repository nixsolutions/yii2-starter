<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m161208_104221_create_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->unique(),
            'title' => $this->string(),
            'content' => $this->text(),
            'description' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pages');
    }
}
