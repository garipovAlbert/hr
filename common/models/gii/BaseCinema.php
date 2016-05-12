<?php

namespace common\models\gii;

use common\models\Account;
use common\models\Applicant;
use common\models\City;
use common\models\Metro;
use common\models\Vacancy;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cinema}}".
 *
 * @property integer $id
 * @property integer $cityId
 * @property string $name
 * @property integer $isActive
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property AccountCinemaLink[] $accountCinemaLinks
 * @property Account[] $accounts
 * @property Applicant[] $applicants
 * @property City $city
 * @property CinemaMetroLink[] $cinemaMetroLinks
 * @property Metro[] $metros
 * @property VacancyCinemaLink[] $vacancyCinemaLinks
 * @property Vacancy[] $vacancies
 */
class BaseCinema extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cinema}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityId', 'isActive', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['name', 'isActive', 'createdAt', 'updatedAt'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['cityId'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['cityId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cityId' => Yii::t('app', 'City ID'),
            'name' => Yii::t('app', 'Name'),
            'isActive' => Yii::t('app', 'Is Active'),
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAccountCinemaLinks()
    {
        return $this->hasMany(AccountCinemaLink::className(), ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['id' => 'accountId'])->viaTable('{{%account_cinema_link}}', ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Applicant::className(), ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cityId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCinemaMetroLinks()
    {
        return $this->hasMany(CinemaMetroLink::className(), ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMetros()
    {
        return $this->hasMany(Metro::className(), ['id' => 'metroId'])->viaTable('{{%cinema_metro_link}}', ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVacancyCinemaLinks()
    {
        return $this->hasMany(VacancyCinemaLink::className(), ['cinemaId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVacancies()
    {
        return $this->hasMany(Vacancy::className(), ['id' => 'vacancyId'])->viaTable('{{%vacancy_cinema_link}}', ['cinemaId' => 'id']);
    }

}