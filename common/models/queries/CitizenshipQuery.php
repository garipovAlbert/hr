<?php

namespace common\models\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Citizenship]].
 * @see Citizenship
 */
class CitizenshipQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Citizenship[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Citizenship
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
