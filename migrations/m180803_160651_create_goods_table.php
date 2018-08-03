<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180803_160651_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string(300)->notNull(),
            'default_price' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->insert('goods', [
            'name' => 'Школьная форма',
            'default_price' => 10000,
            'created_at' => strtotime(date('d.m.Y H:i:s')),
            'updated_at' => strtotime(date('d.m.Y H:i:s')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('goods', ['id' => 1]);
        $this->dropTable('goods');
    }
}
