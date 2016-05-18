<?php

use yii\db\Migration;

class m160518_101258_change_account extends Migration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE {{%account}}
            MODIFY COLUMN `passwordHash`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `email`,
            ADD COLUMN `publicPassword`  varchar(255) NULL AFTER `passwordHash`;
        ");
    }

    public function down()
    {
        echo "m160518_101258_change_account cannot be reverted.\n";

        return false;
    }

}