<?php

use yii\db\Migration;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class m160519_132834_add_name_field_to_applicant extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("
            ALTER TABLE {{%applicant}}
            ADD COLUMN `name`  varchar(255) NOT NULL 
                COMMENT 'firstName + \" \" + lastName' AFTER `lastName`;
        ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m160519_132834_add_name_field_to_applicant cannot be reverted.\n";

        return false;
    }

}