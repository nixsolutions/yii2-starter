<?php

use yii\db\Migration;

/**
 * Handles the creation of table `options`.
 */
class m161210_092314_create_options_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('options', [
            'namespace' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('pk_options', 'options', ['namespace', 'key'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('options');
    }
}
