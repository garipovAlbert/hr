<?php

namespace common\models\queries;

use backend\components\Application as backendApplication;
use common\models\Account;
use common\models\Applicant;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Applicant]].
 * @see Applicant
 */
class ApplicantQuery extends ActiveQuery
{

    public function init()
    {
        parent::init();

        if (Yii::$app instanceof backendApplication && Account::current()) {
            $account = Account::current();
            if (in_array($account->role, [Account::ROLE_CINEMA, Account::ROLE_CONTROLLER])) {
                $ids = $account->getCinemas()->column();
                $this->andWhere(['in', 'applicant.id', $ids]);
            }
        }
    }

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