<?php

namespace common\models;

use common\components\arBehaviors\LinkBehavior;
use common\models\gii\BaseVacancy;
use common\models\queries\VacancyQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * 
 * @property array $cinemaIds
 * @property string $cinemaIdsString
 */
class Vacancy extends BaseVacancy
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
                    'cinemaIds' => 'cinemas',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return VacancyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VacancyQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            ['name', 'unique'],
            ['cinemaIds', 'safe'],
            ['cinemaIdsString', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_replace(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'cinemaIds' => Yii::t('app', 'Cinemas'),
            'cinemaIdsString' => Yii::t('app', 'Cinemas'),
        ]);
    }

    /**
     * Return a string with IDs separated by comma. 
     * Used in editable widget for kartik-v/grid.
     * @return string
     */
    public function getCinemaIdsString()
    {
        return join(',', $this->cinemaIds);
    }

    /**
     * Sets the string with IDs separated by comma. 
     * Used in editable widget for kartik-v/grid.
     * @param string $string
     */
    public function setCinemaIdsString($string)
    {
        $this->cinemaIds = explode(',', $string);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(static::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

}