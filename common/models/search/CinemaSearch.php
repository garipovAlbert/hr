<?php

namespace common\models\search;

use common\models\Cinema;
use yii\data\ActiveDataProvider;

/**
 * @author Albert Garipov <bert320@gmail.com>
 * @see Cinema
 */
class CinemaSearch extends Cinema
{

    public $pageSize = 40;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
//            'metroIds',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'name', 'cityId', 'isActive'],
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
        $query = Cinema::find()->with(['metros', 'city']);


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

        $query->andFilterWhere(['cityId' => $this->cityId]);
        
        $query->andFilterWhere(['isActive' => $this->isActive]);

//        if (strlen($this->metroIds)) {
//            $query->andFilterWhere(['in', '{{%metro}}.id', explode(',', $this->metroIds)]);
//        }


        return $provider;
    }

}