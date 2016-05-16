<?php

namespace common\models\search;

use common\models\Vacancy;
use yii\data\ActiveDataProvider;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * @see Vacancy
 */
class VacancySearch extends Vacancy
{

    public $pageSize = 40;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'name'],
                'safe',
            ],
        ];
    }

    /**
     * @param array $params
     * @param string $formName
     * @return ActiveDataProvider
     */
    public function search($params = [], $formName = null)
    {
        $query = Vacancy::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $provider->pagination->defaultPageSize = $this->pageSize;

        $provider->sort->defaultOrder = [
            'id' => SORT_DESC,
        ];

        // load the seach form data and validate
        if (!($this->load($params, $formName) && $this->validate())) {
            return $provider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $provider;
    }

}