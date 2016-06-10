<?php

use yii\db\Migration;

/**
 * Handles the creation for table `shop_item`.
 */
class m160606_115924_create_shop_item extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('shop_item', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'shop_id' => $this->integer(),
            'price' => $this->integer(),
            'amount' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('shop_item');
    }
}
