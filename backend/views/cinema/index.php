<?php

use backend\components\ButtonGroupColumn;
use backend\helpers\ViewHelper;
use common\models\Cinema;
use common\models\City;
use common\models\Metro;
use common\models\search\CinemaSearch;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Cinema */
/* @var $provider ActiveDataProvider */
/* @var $searchModel CinemaSearch */

$cityList = City::getList();
$metroList = Metro::getList();
?>


<h2><?= Yii::t('app', 'Cinemas') ?></h2>

<hr/>


<!-- create form -->
<?php
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
    ],
    'id' => 'create-form',
]);
?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput(); ?>

        <?php
        echo $form->field($model, 'cityId')
        ->widget(Select2::classname(), [
            'data' => $cityList,
            'language' => 'ru',
            'options' => ['placeholder' => ' '],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>
    </div>

    <div class="col-md-4">
        <?php
        echo $form->field($model, 'metroIds')
        ->widget(Select2::classname(), [
            'data' => $metroList,
            'language' => 'ru',
            'options' => ['multiple' => true, 'placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>
    </div>

</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<!-- /create form -->



<hr/>

<!-- grid -->
<?php
$metroData = ViewHelper::getSelect2Data($metroList);

echo GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
    'condensed' => true,
    'floatHeader' => true,
    'pjax' => true,
    'columns' => [
        [
            'attribute' => 'id',
            'width' => '60px',
        ],
        [
            'attribute' => 'name',
            'class' => EditableColumn::className(),
            'editableOptions' => [
                'formOptions' => ['action' => ['editable']],
                'placement' => PopoverX::ALIGN_TOP,
            ],
        ],
        [
            /* City */
            'attribute' => 'cityId',
            'class' => EditableColumn::className(),
            'value' => 'city.name',
            'editableOptions' => function(Cinema $model, $key, $index) use($cityList) {
                return [
                    'formOptions' => ['action' => ['editable']],
                    'inputType' => Editable::INPUT_SELECT2,
                    'placement' => PopoverX::ALIGN_TOP,
                    'options' => [
                        'data' => $cityList,
                    ],
                ];
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['placeholder' => ' '],
                'data' => $cityList,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ],
            'width' => '200px',
        ],
        [
            /* Metro */
            'attribute' => 'metroIdsString',
            'class' => EditableColumn::className(),
            'value' => function (Cinema $model) {
                return ViewHelper::getMultipleLabel($model->metros);
            },
            'format' => 'raw',
            'editableOptions' => function(Cinema $model, $key, $index) use($metroData) {
                return [
                    'formOptions' => ['action' => ['editable']],
                    'inputType' => Editable::INPUT_SELECT2,
                    'placement' => PopoverX::ALIGN_TOP,
                    'options' => [
                        'pluginOptions' => [
                            'data' => $metroData,
                            'multiple' => true,
                        ],
                    ],
                ];
            },
            'width' => '270px',
        ],
        [
            /* Is Active */
            'attribute' => 'isActive',
            'class' => EditableColumn::className(),
            'value' => function(Cinema $model) {
                return ViewHelper::getBooleanIcon($model->isActive);
            },
            'format' => 'raw',
            'editableOptions' => [
                'formOptions' => ['action' => ['editable']],
                'inputType' => Editable::INPUT_CHECKBOX_X,
                'placement' => PopoverX::ALIGN_TOP,
                'options' => [
                    'pluginOptions' => [
                        'threeState' => false,
                        'iconChecked' => ViewHelper::getBooleanIcon(true),
                        'iconUnchecked' => ViewHelper::getBooleanIcon(false),
                    ],
                ],
            ],
            'filterType' => GridView::FILTER_CHECKBOX_X,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'iconChecked' => ViewHelper::getBooleanIcon(true),
                    'iconUnchecked' => ViewHelper::getBooleanIcon(false),
                ],
            ],
            'width' => '100px',
            'hAlign' => GridView::ALIGN_CENTER,
            'headerOptions' => ['style' => 'text-align: center;'],
            'filterOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'class' => ButtonGroupColumn::className(),
            'template' => '{delete}',
            'width' => '70px',
        ],
    ],
]);
?>
<!-- /grid -->

