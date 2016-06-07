<?php

use backend\widgets\passField\PassField;
use backend\widgets\pickFromList\PickFromList;
use common\models\Account;
use common\models\Cinema;
use common\models\City;
use common\models\search\CinemaSearch;
use common\widgets\Embedjs;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $model Account */
/* @var $form ActiveForm */
?>

<div class="container-fluid">
    <div class="col-md-6">

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off']) ?>

        <!-- disables autocomplete -->
        <input type="text" style="display:none">
        <input type="password" name="passwordFake" id="password-fake" value="" style="visibility: hidden;" />
        <?php Embedjs::begin() ?>
        <script>
            $('#password-fake').show();
            window.setTimeout(function () {
                $('#password-fake').hide();
            }, 1);
        </script>
        <?php Embedjs::end() ?>
        <!-- /disables autocomplete -->

        <?=
        $form->field($model, 'publicPassword', [
            'hintOptions' => ['style' => 'display:none'],
        ])->widget(PassField::className(), [
            'clientOptions' => ['locale' => 'ru'],
            'options' => [
                'autocomplete' => 'off',
                'type' => 'text',
            ],
        ])
        ?>

        <?php
        $roles = Account::roleList();
        unset($roles[Account::ROLE_ADMIN]);
        echo $form->field($model, 'role')->dropDownList($roles, ['prompt' => ''])
        ?>

        <?= $form->field($model, 'position')->textInput() ?>

    </div>
</div>


<div class="container-fluid">
    <div class="col-md-12">
        <!-- cinemaIds -->
        <?php
        $postSearchModel = new CinemaSearch;
        $postProvider = $postSearchModel->search(Yii::$app->request->get());
        $postProvider->pagination->pageSize = 10;

        echo $form->field($model, 'cinemaIds', [
            'options' => ['class' => 'js-related-post-ids-field-row'],
        ])->widget(PickFromList::className(), [
            'id' => 'pickArticlesAndNews',
            'modelClass' => Cinema::className(),
            'searchGridCaption' => Yii::t('app', 'All Cinemas'),
            'linkedGridCaption' => Yii::t('app', 'Added Cinemas'),
            'searchGridConfig' => [
                'dataProvider' => $postProvider,
                'filterModel' => $postSearchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width: 60px;'],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                    ],
                    [
                        /* City */
                        'attribute' => 'cityId',
                        'value' => 'city.name',
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
                ],
            ],
        ])
        ?>
        <!-- /cinemaIds -->
    </div>
</div>

<div class="container-fluid">
    <div class="col-md-6">
        <hr/>
        <?= $form->field($model, 'sendPassword')->checkbox() ?>
    </div>
</div>