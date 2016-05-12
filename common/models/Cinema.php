<?php

namespace common\models;

use common\components\arBehaviors\LinkBehavior;
use common\models\gii\BaseCinema;
use common\models\queries\CinemaQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * 
 * @property array $metroIds
 * @property string $metroIdsString
 */
class Cinema extends BaseCinema
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
            [
                'class' => LinkBehavior::className(),
                'attributes' => [
                    // extra attribute => relation
                    'metroIds' => 'metros',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return CinemaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CinemaQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cityId'], 'required'],
            ['name', 'unique'],
            ['metroIds', 'safe'],
            ['metroIdsString', 'safe'],
            ['cityId', 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],
            ['isActive', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cityId' => Yii::t('app', 'City'),
            'metroIds' => Yii::t('app', 'Metro'),
            'metroIdsString' => Yii::t('app', 'Metro'),
        ];
    }

    public function getMetroLabels()
    {
        return join(",\n", ArrayHelper::getColumn($this->getMetros()->all(), 'name'));
    }

    /**
     * Return a string with IDs separated by comma. 
     * Used in editable widget for kartik-v/grid.
     * @return string
     */
    public function getMetroIdsString()
    {
        return join(',', $this->metroIds);
    }

    /**
     * Sets the string with IDs separated by comma. 
     * Used in editable widget for kartik-v/grid.
     * @param string $string
     */
    public function setMetroIdsString($string)
    {
        $this->metroIds = explode(',', $string);
    }

}