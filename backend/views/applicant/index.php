<?php

use common\models\Applicant;
use common\models\Cinema;
use common\models\Citizenship;
use common\models\City;
use common\models\search\ApplicantSearch;
use common\models\Vacancy;
use common\Rbac;
use common\widgets\Alert;
use common\widgets\Embedjs;
use kartik\grid\CheckboxColumn;
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

$statusList = Applicant::statusList();
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

        <?php
        $statuses = [
            Applicant::STATUS_HIRED,
            Applicant::STATUS_DECLINED,
            Applicant::STATUS_INVITED,
            Applicant::STATUS_NEW,
            Applicant::STATUS_CALL,
            Applicant::STATUS_UNCONFIRMED,
        ];
        ?>
        <table class="" style="width:400px">
            <tr>
                <td style="width:250px">
                    <?= Yii::t('app', 'Total applications found') ?>
                </td>
                <td><?= Applicant::find()->count() ?></td>
            </tr>
            <?php foreach ($statuses as $status): ?>
                <tr>
                    <td><?= $statusList[$status] ?></td>
                    <td><?= Applicant::find()->status($status)->count() ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

</div>

<div class="container-fluid">

    <div class="col-md-12 content-area">

        <p class="clearfix">
            <?= Html::beginForm('', 'post', ['id' => 'checked-form']) ?>
            <?=
            Html::submitButton(Yii::t('app', 'Fast Decline'), [
                'class' => 'btn btn-warning js-checked-button js-decline-all',
                'style' => 'margin-right: 10px',
                'name' => 'decline',
                'value' => '1',
                'disabled' => 'disabled',
            ])
            ?>

            <?php if (Yii::$app->user->can(Rbac::TASK_DELETE_APPLICANT)): ?>
                <?=
                Html::submitButton(Yii::t('yii', 'Delete'), [
                    'class' => 'btn btn-danger js-checked-button js-delete-all',
                    'style' => 'margin-right: 10px',
                    'name' => 'delete',
                    'value' => '1',
                    'disabled' => 'disabled',
                ])
                ?>
            <?php endif; ?>

            <?=
            Html::submitButton(Yii::t('app', 'Export'), [
                'class' => 'btn btn-primary',
                'style' => 'margin-right: 10px',
                'name' => 'export',
                'value' => '1',
            ])
            ?>

        </p>
        <?= Html::endForm() ?>


        <!-- grid -->
        <?php
        $citizenshipList = Citizenship::getList();
        $vacancyList = Vacancy::getList();



        echo GridView::widget([
            'id' => 'applicant-grid',
            'dataProvider' => $provider,
            'filterModel' => $searchModel,
            'condensed' => true,
            'floatHeader' => true,
            'pjax' => true,
            'options' => [
                'style' => 'font-size:90%',
            ],
            'columns' => [
                [
                    'class' => CheckboxColumn::className(),
                    'rowSelectedClass' => GridView::TYPE_INFO,
                    'checkboxOptions' => function() {
                        return [
                            'class' => 'selection-checkbox',
                            'form' => 'checked-form',
                        ];
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
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
                        $class = strtr($model->status, Applicant::statusToCssClass());
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
            ],
        ]);
        ?>
        <!-- /grid -->

        <?php
        Embedjs::begin([
            'data' => [
                'deleteMessage' => Yii::t('app', 'Are you sure you want to delete selected applications?'),
                'declineMessage' => Yii::t('app', 'Are you sure you want to decline selected applications?'),
            ],
        ])
        ?>
        <script>
            var refreshButtonsState = function (keys) {
                console.log(keys);
                if (keys.length) {
                    $('.js-checked-button').removeAttr('disabled');
                } else {
                    $('.js-checked-button').attr('disabled', 'disabled');
                }
            };

            $('#applicant-grid').on('click', 'input[type=checkbox]', function () {
                setTimeout(function () {
                    var keys = $('#applicant-grid').yiiGridView('getSelectedRows');

                    refreshButtonsState(keys);
                }, 10);
            });

            $('.js-delete-all').click(function (e) {
                !confirm(data.deleteMessage) && e.preventDefault();
            });

            $('.js-decline-all').click(function () {
                !confirm(data.declineMessage) && e.preventDefault();
            });
        </script>
        <?php Embedjs::end() ?>


    </div>

</div>