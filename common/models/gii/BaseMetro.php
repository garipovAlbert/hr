<?php

namespace common\models\gii;

use common\models\Cinema;
use common\models\City;
use common\models\queries\MetroQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%metro}}".
 *
 * @property integer $id
 * @property integer $cityId
 * @property string $name
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property CinemaMetroLink[] $cinemaMetroLinks
 * @property Cinema[] $cinemas
 * @property City $city
 */
class BaseMetro extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metro}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityId', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
            [['name', 'createdAt', 'updatedAt'], 'required'],
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
            'createdBy' => Yii::t('app', 'Created By'),
            'updatedBy' => Yii::t('app', 'Updated By'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCinemaMetroLinks()
    {
        return $this->hasMany(CinemaMetroLink::className(), ['metroId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCinemas()
    {
        return $this->hasMany(Cinema::className(), ['id' => 'cinemaId'])->viaTable('{{%cinema_metro_link}}', ['metroId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cityId']);
    }

    /**
     * @inheritdoc
     * @return MetroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetroQuery(get_called_class());
    }
}
