<?php

namespace common\models;

use common\models\gii\BaseApplicant;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class Applicant extends BaseApplicant
{

    const STATUS_NEW = 'NEW';
    const STATUS_HIRED = 'HIRED';
    const STATUS_INVITED = 'INVITED';
    const STATUS_DECLINED = 'DECLINED';
    const STATUS_UNCONFIRMED = 'UNCONFIRMED';
    const STATUS_CALL = 'CALL';

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
                'createdByAttribute' => false, // created by guest user on frontend
                'updatedByAttribute' => 'updatedBy',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return ApplicantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApplicantQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function statusList()
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'Unprocessed application'),
            self::STATUS_HIRED => Yii::t('app', 'Hired'),
            self::STATUS_INVITED => Yii::t('app', 'Invited to interview'),
            self::STATUS_DECLINED => Yii::t('app', 'Declined application'),
            self::STATUS_UNCONFIRMED => Yii::t('app', 'Unconfirmed application'),
            self::STATUS_CALL => Yii::t('app', 'Call to applicant'),
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