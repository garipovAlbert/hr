<?php

namespace common\models\search;

use common\models\City;
use yii\data\ActiveDataProvider;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * @see City
 */
class CitySearch extends City
{

    public $pageSize = 40;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'name', 'isActive'],
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
        $query = City::find();

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
        $query->andFilterWhere(['isActive' => $this->isActive]);

        return $provider;
    }

}