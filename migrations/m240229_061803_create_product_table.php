<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240229_061803_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'SKU' => $this->string()->notNull()->unique(),
            'shippedQty' => $this->integer()->notNull()->defaultValue(0),
            'receivedQty' => $this->integer()->notNull()->defaultValue(0),
            'price' => $this->money(19, 4)->notNull(),
            'box_id' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
