<?php

use backend\components\ButtonGroupColumn;
use common\models\Citizenship;
use common\models\search\CitizenshipSearch;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Citizenship */
/* @var $provider ActiveDataProvider */
/* @var $searchModel CitizenshipSearch */
?>


<h2><?= Yii::t('app', 'Citizenship') ?></h2>

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
            'placeholder' => Yii::t('app', 'Enter Citizenship'),
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
            'class' => ButtonGroupColumn::className(),
            'template' => '{delete}',
            'width' => '70px',
        ],
    ],
]);
?>
<!-- /grid -->

