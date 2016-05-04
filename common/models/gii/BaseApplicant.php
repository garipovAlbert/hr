<?php

namespace common\models\gii;

use common\models\Cinema;
use common\models\queries\ApplicantQuery;
use common\models\Vacancy;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%applicant}}".
 *
 * @property integer $id
 * @property integer $citizenshipId
 * @property integer $vacancyId
 * @property integer $cinemaId
 * @property string $status
 * @property string $firstName
 * @property string $lastName
 * @property integer $age
 * @property integer $phone
 * @property string $email
 * @property string $info
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Citizenship $citizenship
 * @property Vacancy $vacancy
 * @property Cinema $cinema
 */
class BaseApplicant extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applicant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['citizenshipId', 'vacancyId', 'cinemaId', 'age', 'phone', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['vacancyId', 'cinemaId', 'firstName', 'lastName', 'age', 'phone', 'email', 'createdAt', 'updatedAt'], 'required'],
            [['status', 'info'], 'string'],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 255],
            [['citizenshipId'], 'exist', 'skipOnError' => true, 'targetClass' => Citizenship::className(), 'targetAttribute' => ['citizenshipId' => 'id']],
            [['vacancyId'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancyId' => 'id']],
            [['cinemaId'], 'exist', 'skipOnError' => true, 'targetClass' => Cinema::className(), 'targetAttribute' => ['cinemaId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'citizenshipId' => Yii::t('app', 'Citizenship ID'),
            'vacancyId' => Yii::t('app', 'Vacancy ID'),
            'cinemaId' => Yii::t('app', 'Cinema ID'),
            'status' => Yii::t('app', 'Status'),
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'age' => Yii::t('app', 'Age'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'info' => Yii::t('app', 'Info'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCitizenship()
    {
        return $this->hasOne(Citizenship::className(), ['id' => 'citizenshipId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::className(), ['id' => 'vacancyId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCinema()
    {
        return $this->hasOne(Cinema::className(), ['id' => 'cinemaId']);
    }

    /**
     * @inheritdoc
     * @return ApplicantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ApplicantQuery(get_called_class());
    }

}