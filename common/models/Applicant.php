<?php

namespace common\models;

use common\models\gii\BaseApplicant;
use common\models\queries\ApplicantQuery;
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
     * When a guest user filling the application form on frontend
     */
    const SCENARIO_FILL = 'FILL';

    /**
     * When a controller processing the application on backend
     */
    const SCENARIO_PROCESS = 'PROCESS';

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

    public function scenarios()
    {
        return [
            static::SCENARIO_FILL => [
                'firstName', 'lastName', 'age', 'email', 'phone', 'info',
                'citizenshipId', 'vacancyId', 'cinemaId',
            ],
            static::SCENARIO_PROCESS => [
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'firstName', 'lastName', 'age', 'email', 'citizenshipId', 'phone',
                    'vacancyId', 'cinemaId',
                ],
                'required',
            ],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            ['age', 'integer'],
            ['email', 'email'],
            ['phone', 'integer'],
            ['phone', 'string', 'min' => 10, 'max' => 10],
            ['info', 'string'],
            [
                'citizenshipId', 'exist',
                'targetClass' => Citizenship::className(), 'targetAttribute' => 'id',
            ],
            [
                'cinemaId', 'exist',
                'targetClass' => Cinema::className(), 'targetAttribute' => 'id',
            ],
            [
                'vacancyId', 'exist',
                'targetClass' => Vacancy::className(), 'targetAttribute' => 'id',
            ],
        ];
    }

}