<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $hasUpdateTab boolean */

if (!isset($hasUpdateTab)) {
    $hasUpdateTab = true;
}
$actionId = Yii::$app->controller->action->id;
?>

<?php
echo Nav::widget([
    'options' => [
        'class' => 'nav nav-tabs',
        'role' => 'tablist',
        'style' => 'margin-bottom: 40px;',
    ],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-info-sign']),
            'url' => ['view', 'id' => $model->id],
            'active' => $actionId === 'view',
        ],
        [
            'label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']) . ' ' . Yii::t('app', 'Edit'),
            'url' => ['update', 'id' => $model->id],
            'active' => $actionId === 'update',
            'visible' => $hasUpdateTab,
        ],
    ],
]);
?>