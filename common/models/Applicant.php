<?php

namespace common\models;

use common\models\gii\BaseApplicant;
use common\models\queries\ApplicantQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * @property-read string $formattedPhone
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
     * @var int
     */
    public $cityId;

    /**
     * @var int
     */
    public $metroId;

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
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            static::SCENARIO_FILL => [
                'firstName', 'lastName', 'age', 'email', 'phone', 'info',
                'citizenshipId', 'vacancyId', 'cinemaId', 'cityId', 'metroId',
            ],
            static::SCENARIO_PROCESS => [
                'status',
            ],
        ]);
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
            [['firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            ['age', 'integer'],
            ['email', 'email'],
            ['phone', 'integer'],
            ['phone', 'string', 'min' => 10, 'max' => 10],
            ['info', 'string'],
            ['cityId', 'safe'],
            ['metroId', 'safe'],
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

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->name = $this->firstName . ' ' . $this->lastName;

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'citizenshipId' => Yii::t('app', 'Citizenship'),
            'vacancyId' => Yii::t('app', 'Vacancy'),
            'cinemaId' => Yii::t('app', 'Cinema'),
            'cityId' => Yii::t('app', 'City'),
            'status' => Yii::t('app', 'Status'),
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'age' => Yii::t('app', 'Age'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => 'E-mail',
            'info' => Yii::t('app', 'Info'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Date'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'formattedPhone' => Yii::t('app', 'Phone'),
        ];
    }

    /**
     * Sets status to DECLINED
     */
    public function decline()
    {
        if ($this->status !== static::STATUS_DECLINED) {
            $this->status = static::STATUS_DECLINED;
            $this->save(false);
        }
    }

    public static function statusToCssClass()
    {
        return [
            Applicant::STATUS_NEW => 'bg-success',
            Applicant::STATUS_HIRED => 'bg-primary',
            Applicant::STATUS_INVITED => 'bg-info',
            Applicant::STATUS_DECLINED => 'bg-danger',
            Applicant::STATUS_UNCONFIRMED => 'bg-warning',
            Applicant::STATUS_CALL => 'bg-info',
        ];
    }

    /**
     * @return string
     */
    public function getFormattedPhone()
    {
        if ($this->phone) {
            return '+7 (' . substr($this->phone, 0, 3) . ')' . substr($this->phone, 3);
        }
    }

}