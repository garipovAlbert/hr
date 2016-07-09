<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160709_083105_change_phone_type extends Migration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE {{%applicant}}
            MODIFY COLUMN `phone`  char(10) NOT NULL AFTER `age`;
        ");
    }

    public function down()
    {
        echo "m160709_083105_change_phone_type cannot be reverted.\n";

        return false;
    }

}