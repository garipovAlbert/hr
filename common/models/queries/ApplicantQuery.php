<?php

namespace common\models\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Applicant]].
 * @see Applicant
 */
class ApplicantQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Applicant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Applicant
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param string $status
     * @return static
     */
    public function status($status)
    {
        $this->andWhere(['status' => $status]);
        return $this;
    }

}