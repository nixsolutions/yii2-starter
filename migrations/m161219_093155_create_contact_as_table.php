<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact_as`.
 */
class m161219_093155_create_contact_as_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('feedback', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'email' => $this->string(255)->notNull(),
            'message' => $this->text(),
            'status' => "ENUM('new', 'answered') DEFAULT 'new'",
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('feedback');
    }
}
