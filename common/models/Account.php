<?php

namespace common\models;

use common\models\gii\BaseAccount;
use common\models\queries\AccountQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class Account extends BaseAccount
{

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_BLOCKED = 'BLOCKED';
    const ROLE_ADMIN = 'admin';
    const ROLE_CONTROLLER = 'controller';
    const ROLE_CINEMA = 'cinema';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'updatedBy',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function roleList()
    {
        return [
            self::ROLE_ADMIN => Yii::t('app', 'Administrator'),
            self::ROLE_CONTROLLER => Yii::t('app', 'Controller'),
            self::ROLE_CINEMA => Yii::t('app', 'Cinema'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

}