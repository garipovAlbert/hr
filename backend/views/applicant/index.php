<?php

use common\models\Account;
use common\models\Applicant;
use common\models\Cinema;
use common\models\Citizenship;
use common\models\City;
use common\models\queries\ApplicantQuery;
use common\models\search\ApplicantSearch;
use common\models\Vacancy;
use common\Rbac;
use common\widgets\Alert;
use common\widgets\Embedjs;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this View */
/* @var $provider ActiveDataProvider */
/* @var $searchModel ApplicantSearch */
/* @var $countQuery ApplicantQuery */



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

        <div class="row">
            <div class="col-md-4">
                <table class="" style="width:400px">
                    <tr>
                        <th style="width:250px">
                            <?= Yii::t('app', 'Total applications found') ?>
                        </th>
                        <?php $query = clone $countQuery ?>
                        <th><?= $query->count() ?></th>
                    </tr>
                    <?php
                    $statuses = [
                        Applicant::STATUS_NEW,
                        Applicant::STATUS_CALL,
                    ];
                    ?>
                    <?php foreach ($statuses as $status): ?>
                        <?php $query = clone $countQuery ?>
                        <tr>
                            <td><?= $statusList[$status] ?></td>
                            <td><?= $query->status($status)->count() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-4">
                <table class="" style="width:400px">
                    <?php
                    $statuses = [
                        Applicant::STATUS_DECLINED,
                        Applicant::STATUS_INVITED,
                        Applicant::STATUS_HIRED,
                    ];
                    ?>
                    <?php foreach ($statuses as $status): ?>
                        <?php $query = clone $countQuery ?>
                        <tr>
                            <td style="width:250px"><?= $statusList[$status] ?></td>
                            <td><?= $query->status($status)->count() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <br/>
                <?php
                /* @var $form ActiveForm */
                $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'layout' => 'horizontal'
                ]);
                ?>

                <?=
                $form->field($searchModel, 'showAll', ['labelOptions' => ['class' => 'control-label col-sm-4']])
                ->dropDownList([0 => Yii::t('yii', 'No'), 1 => Yii::t('yii', 'Yes')], [
                    'style' => 'width: 120px;'
                ])
                ?>

                <?php ActiveForm::end(); ?>

            </div>
            <?php
            Embedjs::begin([
                'data' => [
                    'showAllTriggerId' => Html::getInputId($searchModel, 'showAll'),
                ],
            ])
            ?>
            <script>
                $('#' + data.showAllTriggerId).change(function () {
                    $(this).closest('form').submit();
                });
            </script>
            <?php Embedjs::end() ?>

        </div>


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
        $statusList = Applicant::statusList();
        unset($statusList[Applicant::STATUS_UNCONFIRMED]);

        if (Account::current()->role === Account::ROLE_ADMIN) {
            $cityList = City::getList();
            $cinemaList = Cinema::getSelect2List();
        } else {
            $cityList = City::getList(Account::current()->getCityIds());
            $cinemaList = Cinema::getSelect2List(Account::current()->getCityCinemaIds());
        }



        echo GridView::widget([
            'id' => 'applicant-grid',
            'dataProvider' => $provider,
            'filterModel' => $searchModel,
            'condensed' => true,
            'floatHeader' => true,
            'pjax' => false,
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
                    'width' => '40px',
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
                    'width' => '120px',
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
                    'width' => '150px',
                ],
                [
                    'attribute' => 'cityId',
                    'value' => 'cinema.city.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => $cityList,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '160px',
                ],
                [
                    'attribute' => 'cinemaId',
                    'value' => 'cinema.name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['placeholder' => ' '],
                        'data' => $cinemaList,
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ],
                    'width' => '250px',
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
                        'data' => $statusList,
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