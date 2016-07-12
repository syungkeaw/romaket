<?php

use yii\db\Migration;

/**
 * Handles the creation for table `blacklist`.
 */
class m160708_115400_create_blacklist extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blacklist', [
            'id' => $this->primaryKey(),
            'character' => $this->string(),
            'reason' => $this->string(),
            'server' => $this->string(),
            'parent_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blacklist');
    }
}
