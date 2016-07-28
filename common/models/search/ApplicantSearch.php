<?php

namespace common\models\search;

use common\helpers\DateHelper;
use common\models\Applicant;
use common\models\queries\AccountQuery;
use common\models\queries\ApplicantQuery;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * @see Applicant
 */
class ApplicantSearch extends Applicant
{

    public $pageSize = 1000;

    /**
     * @var AccountQuery
     */
    public $query;

    /**
     * @var int
     */
    public $onlyOwnCinemas = 1;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'cityId',
            'onlyOwn',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'name', 'email', 'cityId', 'cinemaId', 'vacancyId', 'citizenshipId',
                    'status', 'createdAt', 'age', 'onlyOwnCinemas',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_replace(parent::attributeLabels(), [
            'createdAt' => 'Date',
            'onlyOwnCinemas' => Yii::t('app', 'Only for own Cinema'),
        ]);
    }

    /**
     * @param array $params
     * @param string $formName
     * @return ActiveDataProvider
     */
    public function search($params = [], $formName = null)
    {
        /* @var $query ApplicantQuery */
        $query = $this->query ? $this->query : Applicant::find();

        $query->joinWith([
            'cinema.city',
            'vacancy',
        ]);

        $query->andWhere(['!=', 'status', Applicant::STATUS_UNCONFIRMED]);

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $provider->pagination->defaultPageSize = $this->pageSize;

        $provider->sort->defaultOrder = [
            'id' => SORT_DESC,
        ];

        $loaded = $this->load($params, $formName);

        if ($this->onlyOwnCinemas) {
            $query->onlyOwnCinema();
        } else {
            $query->onlyOwnCityCinema();
        }

        // load the seach form data and validate
        if (!($loaded && $this->validate())) {
            return $provider;
        }

        $query->andFilterWhere(['applicant.id' => $this->id]);
        $query->andFilterWhere(['like', 'applicant.name', $this->name]);

        $query->andFilterWhere(['citizenshipId' => $this->citizenshipId]);
        $query->andFilterWhere(['vacancyId' => $this->vacancyId]);
        $query->andFilterWhere(['cinemaId' => $this->cinemaId]);
        $query->andFilterWhere(['city.id' => $this->cityId]);
        $query->andFilterWhere(['applicant.age' => $this->age]);

        $query->andFilterWhere(['applicant.status' => $this->status]);

        if (strlen($this->createdAt)) {
            list($start, $end) = $this->parseDateRange($this->createdAt);
            if ($start) {
                $query->andFilterWhere(['between', 'applicant.createdAt', $start, $end]);
            }
        }

        return $provider;
    }

    /**
     * @param string $dateRange Example "19.05.2016 - 21.06.2016"
     * @return array 0 - start timestamp, 1 - end timestamp
     */
    private function parseDateRange($dateRange)
    {
        $m = null;
        if (preg_match('/([^\s]+) \- ([^\s]+)/', $dateRange, $m) !== 1) {
            return false;
        }

        $result = [];
        for ($i = 1; $i <= 2; $i++) {
            $ts = DateHelper::parseDateValue($m[$i], Yii::$app->formatter->dateFormat);
            if (!$ts) {
                return false;
            }
            $result[] = $ts;
        }

        $result[1] += (60 * 60 * 24); // plus 24 hours - end of day

        return $result;
    }

}