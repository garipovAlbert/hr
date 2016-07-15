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
        return array_replace(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'cityId' => Yii::t('app', 'City'),
            'metroIds' => Yii::t('app', 'Metro'),
            'metroIdsString' => Yii::t('app', 'Metro'),
        ]);
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

    /**
     * Returns cinema list grouped by city to use in kartik-v Select2 widget.
     * @return array
     */
    public static function getSelect2List(array $ids = null)
    {
        $query = City::find()->active()
        ->with([
            'cinemas' => function($q) use($ids) {
                $q->active()->orderBy(['name' => SORT_ASC]);
                if ($ids !== null) {
                    $q->andWhere(['in', 'id', $ids]);
                }
            },
        ])
        ->orderBy(['name' => SORT_ASC]);


        $cinemaList = [];
        foreach ($query->all() as $city) {
            $cinemaList[$city->name] = ArrayHelper::map($city->cinemas, 'id', 'name');
        }

        return $cinemaList;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'city',
        ];
    }

}