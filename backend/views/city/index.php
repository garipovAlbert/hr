<?php

use backend\components\ButtonGroupColumn;
use backend\helpers\ViewHelper;
use common\models\City;
use common\models\search\CitySearch;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model City */
/* @var $provider ActiveDataProvider */
/* @var $searchModel CitySearch */
?>


<h2><?= Yii::t('app', 'Cities') ?></h2>

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
    'layout' => 'inline',
]);
?>

<div class="row">

    <div class="col-md-12">
        <?=
        $form->field($model, 'name')->textInput([
            'placeholder' => Yii::t('app', 'Enter City Name'),
        ]);
        ?>
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>
<!-- /create form -->



<hr/>

<!-- grid -->
<?php
echo GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
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
            /* Cinemas */
            'header' => Yii::t('app', 'Cinemas'),
            'value' => function(City $model) {
                $names = [];
                foreach ($model->cinemas as $item) {
                    $names[] = Html::encode($item->name);
                }
                return join('<br/> ', $names);
            },
            'format' => 'raw',
        ],
        [
            /* Metro */
            'header' => Yii::t('app', 'Metro'),
            'value' => function(City $model) {
                $names = [];
                foreach ($model->metros as $item) {
                    $names[] = Html::encode($item->name);
                }
                return join('<br/> ', $names);
            },
            'format' => 'raw',
        ],
        [
            /* Is Active */
            'attribute' => 'isActive',
            'class' => EditableColumn::className(),
            'value' => function(City $model) {
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

