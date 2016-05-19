<?php

use backend\components\ButtonGroupColumn;
use backend\widgets\ActionButton;
use common\models\Applicant;
use common\models\Cinema;
use common\models\Citizenship;
use common\models\City;
use common\models\search\ApplicantSearch;
use common\models\Vacancy;
use common\widgets\Alert;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this View */
/* @var $provider ActiveDataProvider */
/* @var $searchModel ApplicantSearch */



$this->context->layout = 'base';
?>

<div class="container">

    <div class="col-md-12 content-area">
        <?=
        Breadcrumbs::widget([
            'homeLink' => false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>

        <?= Alert::widget() ?>

        <h2><?= Yii::t('app', 'Applications') ?></h2>
        <br/>


    </div>

</div>

<div class="container-fluid">

    <div class="col-md-12 content-area">
        <!-- grid -->
        <?php
        $citizenshipList = Citizenship::getList();
        $vacancyList = Vacancy::getList();

        $statusList = Applicant::statusList();

        echo GridView::widget([
            'dataProvider' => $provider,
            'filterModel' => $searchModel,
            'condensed' => true,
            'floatHeader' => true,
            'pjax' => true,
            'options' => [
                'style' => 'font-size:90%',
            ],
            'columns' => [
//                [
//                    'class' => CheckboxColumn::className(),
//                    'rowSelectedClass' => GridView::TYPE_INFO,
//                ],
                [
                    'attribute' => 'id',
                    'width' => '60px',
                ],
                [
                    'attribute' => 'createdAt',
                    'format' => 'date',
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'language' => 'ru',
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => str_replace('php:', '', Yii::$app->formatter->dateFormat),
                            ]
                        ],
                        'presetDropdown' => true,
                    ],
                    'width' => '200px',
                ],
                [
                    'attribute' => 'name',
                    'value' => function(Applicant $model) {
                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
//                    'width' => '170px',
                ],
                [
                    'attribute' => 'age',
                    'width' => '80px',
                ],
                [
                    'attribute' => 'citizenshipId',
                    'value' => 'citizenship.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => Citizenship::getList(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '170px',
                ],
                [
                    'attribute' => 'vacancyId',
                    'value' => 'vacancy.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => Vacancy::getList(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '170px',
                ],
                [
                    'attribute' => 'cityId',
                    'value' => 'cinema.city.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => City::getList(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '200px',
                ],
                [
                    'attribute' => 'cinemaId',
                    'value' => 'cinema.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => Cinema::getSelect2List(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '200px',
                ],
                [
                    'attribute' => 'status',
                    'value' => function(Applicant $model) use ($statusList) {
                        return ArrayHelper::getValue($statusList, $model->status);
                    },
                    'contentOptions' => function(Applicant $model) {
                        $class = strtr($model->status, [
                            Applicant::STATUS_NEW => 'bg-success',
                            Applicant::STATUS_HIRED => 'bg-primary',
                            Applicant::STATUS_INVITED => 'bg-info',
                            Applicant::STATUS_DECLINED => 'bg-danger',
                            Applicant::STATUS_UNCONFIRMED => 'bg-warning',
                            Applicant::STATUS_CALL => 'bg-info',
                        ]);

                        return [
                            'class' => $class,
                        ];
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => Applicant::statusList(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '230px',
                ],
                [
                    'class' => ButtonGroupColumn::className(),
                    'header' => false,
                    'template' => '{decline}',
                    'buttons' => [
                        'decline' => function($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', 'Fast Decline'),
                                'aria-label' => Yii::t('yii', 'Fast Decline'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to decline this application?'),
                                'data-method' => 'post',
                                'data-pjax' => '1',
                            ];

                            return ActionButton::widget([
                                'url' => $url,
                                'options' => $options,
                                'type' => 'warning xs',
                                'label' => Yii::t('app', 'Fast Decline'),
                            ]);
                        },
                    ],
                    'width' => '130px',
                ],
                [
                    'class' => ButtonGroupColumn::className(),
                    'header' => false,
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];

                            return ActionButton::widget([
                                'url' => $url,
                                'options' => $options,
                                'type' => 'danger xs',
                                'label' => Yii::t('yii', 'Delete'),
                            ]);
                        },
                    ],
                    'width' => '100px',
                ],
            ],
        ]);
        ?>
        <!-- /grid -->


    </div>

</div>