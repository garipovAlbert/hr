<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160504_225106_account_username extends Migration
{

    public function up()
    {
        // replace `firstName` and `lastName` with single field `username`
        $this->execute("
            ALTER TABLE {{%account}}
                DROP COLUMN `firstName`,
                DROP COLUMN `lastName`,
                ADD COLUMN `username`  varchar(255) NOT NULL AFTER `email`;
        ");

        // set `email` NOT NULL, drop `login` (e-mail used as login)
        $this->execute("
            ALTER TABLE {{%account}}
                DROP COLUMN `login`,
                MODIFY COLUMN `email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `authKey`;
        ");
    }

    public function down()
    {
        echo "m160504_225106_account_username cannot be reverted.\n";

        return false;
    }

}