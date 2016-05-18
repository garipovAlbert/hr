<?php

use common\models\Account;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Account */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Edit account');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Accounts'),
        'url' => ['index'],
    ],
    $model->username,
    Yii::t('app', 'Edit'),
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
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>