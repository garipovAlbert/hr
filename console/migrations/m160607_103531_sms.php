<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160607_103531_sms extends Migration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE {{%applicant}}
            ADD COLUMN `ip`  varchar(255) NULL AFTER `info`,
            ADD COLUMN `confirmationCode`  varchar(255) NULL AFTER `ip`;
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS {{%sms_log}} (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `result` text,
              `code` text,
              `message` text,
              `description` text,
              `smsId` varchar(255) DEFAULT NULL,
              `phone` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        echo "m160607_103531_sms cannot be reverted.\n";

        return false;
    }

}