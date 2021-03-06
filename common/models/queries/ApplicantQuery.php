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

    /**
     * Show applicants for only cinemas related with current user
     * @return ApplicantQuery
     */
    public function onlyOwnCinema()
    {
        if (Yii::$app instanceof backendApplication && Account::current()) {
            $account = Account::current();
            if (in_array($account->role, [Account::ROLE_CINEMA, Account::ROLE_CONTROLLER])) {
                $relatedCinemaIds = $account->getRelatedCinemaIds();

                $this->andWhere(['in', 'applicant.cinemaId', $relatedCinemaIds]);
            }
        }

        return $this;
    }

    /**
     * Show applicants for only cinemas in user's city
     * @return ApplicantQuery
     */
    public function onlyOwnCityCinema()
    {
        if (Yii::$app instanceof backendApplication && Account::current()) {
            $account = Account::current();
            if (in_array($account->role, [Account::ROLE_CINEMA, Account::ROLE_CONTROLLER])) {
                $cityCinemaIds = $account->getCityCinemaIds();
                $relatedCinemaIds = $account->getRelatedCinemaIds();

                $this->andWhere([
                    'or',
                    ['in', 'applicant.cinemaId', $relatedCinemaIds],
                    [
                        'and',
                        ['in', 'applicant.cinemaId', $cityCinemaIds],
                        ['<', 'applicant.createdAt', time() - 60 * 60 * 24],
                    ]
                ]);
            }
        }

        return $this;
    }

}