<?php

use backend\components\ButtonGroupColumn;
use backend\helpers\ViewHelper;
use common\models\City;
use common\models\Metro;
use common\models\search\MetroSearch;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Metro */
/* @var $provider ActiveDataProvider */
/* @var $searchModel MetroSearch */

$cityList = City::getList();
?>


<h2><?= Yii::t('app', 'Metro Stations') ?></h2>

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
    </div>

    <div class="col-md-4">
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

</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<!-- /create form -->



<hr/>

<!-- grid -->
<?php
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
            'editableOptions' => function($model, $key, $index) use($cityList) {
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
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'data' => $cityList,
            ],
            'width' => '200px',
        ],
        [
            /* Metro */
            'header' => Yii::t('app', 'Metro'),
            'value' => function($model) {
                return ViewHelper::getMultipleLabel($model->cinemas);
            },
            'format' => 'raw',
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

