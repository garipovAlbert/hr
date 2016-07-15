<?php

use common\models\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model LoginForm */

$this->title = 'Login';
Yii::$app->controller->layout = 'login';
?>

<?php
$form = ActiveForm::begin([
    'id' => 'login-form'
]);
?>

<!-- email -->
<?=
$form->field($model, 'email', [
    'template' => '{input}',
    'options' => [
        'class' => 'form-group field-loginform-email required has-error',
    ],
])
->textInput([
    'autofocus' => true,
    'placeholder' => 'Имя пользователя',
])
?>
<!-- /email -->

<!-- password -->
<?=
$form->field($model, 'password', [
    'template' => '{input}',
    'options' => [
        'class' => 'form-group field-loginform-email required has-error',
    ],
])
->passwordInput([
    'placeholder' => 'Пароль',
])
?>
<!-- /password -->

<div class="form-group">
    <button name="login-button" class="btn btn-primary" type="submit">Login</button>
</div>

<?php ActiveForm::end(); ?>
