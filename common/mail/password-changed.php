<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
?>
Здравствуйте, <?= Html::encode($model->username) ?>!<br/>
===============================================<br/>
<br/>
Пароль к Вашему аккаунту был изменен.<br/>
Новый пароль: <?= Html::encode($model->publicPassword) ?><br/>