<?php

namespace common\models\gii;

use common\models\Applicant;
use common\models\Cinema;
use common\models\queries\VacancyQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%vacancy}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Applicant[] $applicants
 * @property VacancyCinemaLink[] $vacancyCinemaLinks
 * @property Cinema[] $cinemas
 */
class BaseVacancy extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vacancy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'createdAt', 'updatedAt'], 'required'],
            [['description'], 'string'],
            [['createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Applicant::className(), ['vacancyId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVacancyCinemaLinks()
    {
        return $this->hasMany(VacancyCinemaLink::className(), ['vacancyId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCinemas()
    {
        return $this->hasMany(Cinema::className(), ['id' => 'cinemaId'])->viaTable('{{%vacancy_cinema_link}}', ['vacancyId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return VacancyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VacancyQuery(get_called_class());
    }

}