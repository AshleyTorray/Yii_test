<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%box}}`.
 */
class m240228_085921_create_box_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%box}}', [
            'id' => $this->primaryKey(),
            'weight' => $this->decimal(10, 2)->notNull(),
            'width' => $this->decimal(10, 2)->notNull(),
            'length' => $this->decimal(10, 2)->notNull(),
            'height' => $this->decimal(10, 2)->notNull(),
            'reference' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%box}}');
    }
}
