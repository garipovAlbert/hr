<?php

use yii\db\Migration;

/**
 * Handles the dropping for table `user`.
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160505_004725_drop_user_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('user');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m160505_004725_drop_user_table cannot be reverted.\n";

        return false;
    }

}