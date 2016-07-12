<?php

use yii\db\Migration;

/**
 * Handles the creation for table `blacklist_pump`.
 */
class m160708_115940_create_blacklist_pump extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blacklist_pump', [
            'blacklist_id' => $this->integer(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blacklist_pump');
    }
}
