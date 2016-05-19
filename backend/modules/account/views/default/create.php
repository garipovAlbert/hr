<?php

use common\models\Account;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Account */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Create a new Account');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Accounts'),
        'url' => ['index'],
    ],
    Yii::t('app', 'Create a new Account'),
];
?>


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

<?=
$this->render('_formRows', [
    'model' => $model,
    'form' => $form,
])
?>

<hr/>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
