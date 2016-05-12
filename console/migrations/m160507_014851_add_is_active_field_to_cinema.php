<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160507_014851_add_is_active_field_to_cinema extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("
            ALTER TABLE {{%cinema}}
            ADD COLUMN `isActive`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `name`;
        ");

        // fix: default = 1
        $this->execute("
            ALTER TABLE {{%city}}
            MODIFY COLUMN `isActive`  tinyint(1) NOT NULL DEFAULT 1 AFTER `name`;
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m160507_014851_add_is_active_field_to_cinema cannot be reverted.\n";

        return false;
    }

}