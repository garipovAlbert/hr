<?php

use common\models\Account;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Account */
?>
Здравствуйте, <?= Html::encode($model->username) ?>!<br/>
===============================================<br/>
<br/>
На Ваш адрес электронной почты заведена учетная запись.<br/>
Ваш логин: <?= Html::encode($model->email) ?><br/>
Ваш пароль: <?= Html::encode($model->publicPassword) ?><br/>
<br/>
===============================================<br/>
Если Вы не понимаете о чем идет речь, то удалите это письмо.<br/>