<?php

use yii\db\Migration;

/**
 * Handles the creation of table `prices`.
 */
class m180803_163039_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'start_date' => $this->integer()->notNull(),
            'end_date' => $this->integer()->notNull()->defaultValue(0),
        ]);

        // creates index for column `goods_id`
        $this->createIndex(
            'idx-prices-goods_id',
            'prices',
            'goods_id'
        );

        // add foreign key for table `goods`
        $this->addForeignKey(
            'fk-prices-goods_id',
            'prices',
            'goods_id',
            'goods',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->insert('prices', [
            'goods_id' => 1,
            'price' => 8000,
            'start_date' => 1451682000,
            'end_date' => 0,
        ]);

        $this->insert('prices', [
            'goods_id' => 1,
            'price' => 12000,
            'start_date' => 1462050000,
            'end_date' => 1483218000,
        ]);

        $this->insert('prices', [
            'goods_id' => 1,
            'price' => 15000,
            'start_date' => 1467320400,
            'end_date' => 1473454800,
        ]);

        $this->insert('prices', [
            'goods_id' => 1,
            'price' => 20000,
            'start_date' => 1496264400,
            'end_date' => 1508446800,
        ]);

        $this->insert('prices', [
            'goods_id' => 1,
            'price' => 5000,
            'start_date' => 1513285200,
            'end_date' => 1514667600,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->delete('goods', ['id' => 5]);
        $this->delete('goods', ['id' => 4]);
        $this->delete('goods', ['id' => 3]);
        $this->delete('goods', ['id' => 2]);
        $this->delete('goods', ['id' => 1]);

        // drops foreign key for table `goods`
        $this->dropForeignKey(
            'fk-prices-goods_id',
            'prices'
        );

        // drops index for column `goods_id`
        $this->dropIndex(
            'idx-prices-goods_id',
            'prices'
        );

        $this->dropTable('prices');
    }
}
