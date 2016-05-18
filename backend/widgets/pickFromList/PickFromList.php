<?php

namespace backend\widgets\pickFromList;

use backend\widgets\ActionButton;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class PickFromList extends InputWidget
{

    /**
     * @var array
     * @see GridView
     */
    public $searchGridConfig;

    /**
     * @var string
     */
    public $searchGridCaption;

    /**
     * @var array
     * @see GridView
     */
    public $linkedGridConfig;

    /**
     * @var string
     */
    public $linkedGridCaption;

    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string 
     */
    public $nameAttribute = 'name';

    public function init()
    {
        parent::init();

        if (!isset($this->searchGridConfig['columns'])) {
            $this->searchGridConfig['columns'] = [];
        }

        $this->searchGridConfig['id'] = $this->id . '-search-grid';
        $this->searchGridConfig['layout'] = "{items}\n{pager}";
        $this->searchGridConfig['caption'] = $this->searchGridCaption;



        array_push($this->searchGridConfig['columns'], [
            'contentOptions' => ['style' => 'width: 20px; text-align: center;'],
            'content' => function($model) {
                return ActionButton::widget([
                    'tagName' => 'div',
                    'glyphicon' => 'plus-sign',
                    'type' => 'success xs',
                    'options' => [
                        'data-id' => $model->id,
                        'data-add' => true,
                    ],
                ]);
            }
        ]);


        if (!isset($this->linkedGridConfig)) {
            $this->linkedGridConfig = [];
        }


        $this->linkedGridConfig['id'] = $this->id . '-linked-grid';
        $this->linkedGridConfig['layout'] = "{items}\n{pager}";
        $this->linkedGridConfig['caption'] = $this->linkedGridCaption;

        $mc = $this->modelClass;
        /* @var $query ActiveQuery */
        $query = $mc::find();
        $linkedIds = Yii::$app->request->get('linkedIds');
        if ($linkedIds === null) {
            $value = $this->model->{$this->attribute};
            $ids = is_array($value) ? $value : explode(',', $value);
        } else {
            $ids = explode(',', trim($linkedIds));
        }

        $query->andWhere(['in', 'id', $ids]);
        if (count($ids)) {
            $idsString = join(',', array_map('intval', $ids));
            $query->orderBy([new Expression("FIELD(id, {$idsString})")]);
        }


        $linkedDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->linkedGridConfig['dataProvider'] = $linkedDataProvider;


        $pk = $mc::tableName() . '.id';

        $this->searchGridConfig['dataProvider']
        ->query
        ->andWhere(['not in', $pk, $ids]);


        $this->linkedGridConfig['columns'] = [
            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width: 60px;'],
            ],
            [
                'attribute' => $this->nameAttribute,
            ],
            [
                'contentOptions' => ['style' => 'width: 20px; text-align: center;'],
                'content' => function($model) {
                    return ActionButton::widget([
                        'tagName' => 'div',
                        'glyphicon' => 'remove-circle',
                        'type' => 'danger xs',
                        'options' => [
                            'data-id' => $model->id,
                            'data-remove' => true,
                        ],
                    ]);
                }
            ]
        ];
    }

    public function run()
    {
        $inputId = Html::getInputId($this->model, $this->attribute);

        return $this->render('pickFromList', [
            'searchGridConfig' => $this->searchGridConfig,
            'linkedGridConfig' => $this->linkedGridConfig,
            'id' => $this->id,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'inputId' => $inputId,
        ]);
    }

}