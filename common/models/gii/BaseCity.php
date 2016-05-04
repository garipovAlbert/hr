<?php

namespace common\models\gii;

use common\models\Cinema;
use common\models\Metro;
use common\models\queries\CityQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $isActive
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Cinema[] $cinemas
 * @property Metro[] $metros
 */
class BaseCity extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'isActive', 'createdAt', 'updatedAt'], 'required'],
            [['isActive', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt'], 'integer'],
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
    public function getCinemas()
    {
        return $this->hasMany(Cinema::className(), ['cityId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMetros()
    {
        return $this->hasMany(Metro::className(), ['cityId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
