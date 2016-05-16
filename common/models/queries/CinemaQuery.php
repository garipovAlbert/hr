<?php

namespace common\models\queries;

use common\models\Cinema;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Cinema]].
 * @see Cinema
 */
class CinemaQuery extends ActiveQuery
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
     * @return Cinema[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cinema
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}