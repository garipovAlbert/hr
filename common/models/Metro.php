<?php

namespace common\models;

use common\models\gii\BaseMetro;
use common\models\queries\MetroQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class Metro extends BaseMetro
{

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
     * @return MetroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetroQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(Metro::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cityId'], 'required'],
            ['name', 'unique'],
            ['cityId', 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_replace(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'cityId' => Yii::t('app', 'City'),
        ]);
    }

}