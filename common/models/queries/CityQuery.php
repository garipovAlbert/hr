<?php

namespace common\models\queries;

use common\models\City;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\City]].
 * @see City
 */
class CityQuery extends ActiveQuery
{

    /**
     * @return static
     */
    public function active()
    {
        $this->andWhere(['isActive' => 1]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return City[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return City
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}