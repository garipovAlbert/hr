<?php

namespace common\models;

use common\models\gii\BaseCity;
use common\models\queries\CityQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class City extends BaseCity
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
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getList(array $ids = null)
    {
        $query = City::find()->active()->orderBy(['name' => SORT_ASC]);
        if ($ids !== null) {
            $query->andWhere(['in', 'id', $ids]);
        }

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['isActive', 'in', 'range' => [0, 1]],
        ];
    }

}