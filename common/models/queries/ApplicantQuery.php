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
                $relatedCinemaIds = $account->getRelatedCinemaIds();
                $cityCinemaIds = $account->getCityCinemaIds();

                $this->andWhere([
                    'or',
                    ['in', 'applicant.cinemaId', $relatedCinemaIds],
                    [
                        // show to other cinema managers in city 
                        // if the application has been sent more than 24 hours ago
                        'and',
                        ['in', 'applicant.cinemaId', $cityCinemaIds],
                        ['<', 'applicant.createdAt', time() - 60 * 60 * 24],
                    ],
                ]);
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

    /**
     * @param string $status
     * @return static
     */
    public function exceptStatus($status)
    {
        $this->andWhere(['!=', 'status', $status]);
        return $this;
    }

}