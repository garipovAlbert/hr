<?php

use backend\components\ButtonGroupColumn;
use backend\helpers\ViewHelper;
use common\models\City;
use common\models\search\VacancySearch;
use common\models\Vacancy;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Vacancy */
/* @var $provider ActiveDataProvider */
/* @var $searchModel VacancySearch */
/* @var $cities City[] */

$cinemaList = [];
foreach ($cities as $city) {
    $cinemaList[$city->name] = ArrayHelper::map($city->cinemas, 'id', 'name');
}
?>


<h2><?= Yii::t('app', 'Vacancies') ?></h2>

<hr/>


<!-- create form -->
<?php
/* @var $form ActiveForm */
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
        echo $form->field($model, 'cinemaIds')
        ->widget(Select2::classname(), [
            'data' => $cinemaList,
            'language' => 'ru',
            'options' => ['multiple' => true, 'placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>
    </div>

    <div class="col-md-8">
        <?= $form->field($model, 'description')->textarea(['rows' => 5]); ?>
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
$cinemaData = [];
foreach ($cinemaList as $cityName => $cinemas) {
    $cinemaData[] = ['text' => $cityName, 'children' => ViewHelper::getSelect2Data($cinemas)];
}

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
            'width' => '260px',
        ],
        [
            // metro
            'attribute' => 'cinemaIdsString',
            'class' => EditableColumn::className(),
            'value' => function (Vacancy $model) {
                return ViewHelper::getMultipleLabel($model->cinemas);
            },
            'format' => 'raw',
            'editableOptions' => function(Vacancy $model, $key, $index) use($cinemaData) {
                return [
                    'formOptions' => ['action' => ['editable']],
                    'inputType' => Editable::INPUT_SELECT2,
                    'placement' => PopoverX::ALIGN_TOP,
                    'options' => [
                        'pluginOptions' => [
                            'data' => $cinemaData,
                            'multiple' => true,
                        ],
                    ],
                ];
            },
            'width' => '270px',
        ],
        [
            'attribute' => 'description',
            'class' => EditableColumn::className(),
            'value' => function($model) {
                return nl2br($model->description);
            },
            'format' => 'raw',
            'editableOptions' => [
                'formOptions' => ['action' => ['editable']],
                'inputType' => Editable::INPUT_TEXTAREA,
                'asPopover' => false,
                'submitOnEnter' => false,
            ],
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

