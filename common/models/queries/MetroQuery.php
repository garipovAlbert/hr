<?php

namespace common\models\queries;

use common\models\Metro;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Metro]].
 * @see Metro
 */
class MetroQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Metro[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Metro
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}