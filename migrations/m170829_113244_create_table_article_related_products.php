<?php

use yii\db\Migration;

class m170829_113244_create_table_article_related_products extends Migration
{
    private $tableName = 'article_related_products';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'article_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'position' => $this->integer()
        ]);
        $this->addPrimaryKey($this->tableName . '_pk', $this->tableName, ['article_id', 'product_id']);
        $this->addForeignKey($this->tableName . '_article_fk', $this->tableName, 'article_id', 'article', 'id');
        $this->addForeignKey($this->tableName . '_product_fk', $this->tableName, 'product_id', 'shop_product', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey($this->tableName . '_article_fk', $this->tableName);
        $this->dropForeignKey($this->tableName . '_product_fk', $this->tableName);
        $this->dropPrimaryKey($this->tableName . '_pk', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
