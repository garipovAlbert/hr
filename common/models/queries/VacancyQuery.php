<?php

namespace common\models\queries;

use common\models\Vacancy;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Vacancy]].
 * @see Vacancy
 */
class VacancyQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Vacancy[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vacancy
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
