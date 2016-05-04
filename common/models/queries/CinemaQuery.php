<?php

namespace common\models\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Cinema]].
 * @see Cinema
 */
class CinemaQuery extends ActiveQuery
{

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