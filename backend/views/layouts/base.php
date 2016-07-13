<?php

use common\models\Account;
use common\Rbac;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\Application;
use yii\web\View;

/* @var $this View */
/* @var $content string */

$cId = Yii::$app->controller->id;

$module = Yii::$app->controller->module;
if ($module instanceof Application) {
    $mId = null;
} else {
    $mId = Yii::$app->controller->module->id;
}
?>

<?php $this->beginContent('@app/views/layouts/blank.php'); ?>


<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => 'D.R.S.<br/><small><i>Digital Recruitment System</i></small>',
        'brandOptions' => ['class' => 'karo-logo'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [];

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => Yii::t('app', 'Applications'),
            'url' => ['/applicant'],
            'active' => "$mId/$cId" === '//applicant',
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Account management'),
            'url' => ['/account/default/index'],
            'active' => "$mId" === 'account',
            'visible' => Yii::$app->user->can(Rbac::TASK_MANAGE_ACCOUNT),
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Add'),
            'visible' => Yii::$app->user->can(Rbac::TASK_MANAGE_OBJECTS),
            'items' => [
                [
                    'label' => Yii::t('app', 'Cinema #accusative#'),
                    'url' => ['/cinema'],
                    'active' => "/$mId/$cId" === '//cinema',
                ],
                [
                    'label' => Yii::t('app', 'Vacancy #accusative#'),
                    'url' => ['/vacancy'],
                    'active' => "/$mId/$cId" === '//vacancy',
                ],
                [
                    'label' => Yii::t('app', 'City #accusative#'),
                    'url' => ['/city'],
                    'active' => "/$mId/$cId" === '//city',
                ],
                [
                    'label' => Yii::t('app', 'Metro #accusative#'),
                    'url' => ['/metro'],
                    'active' => "/$mId/$cId" === '//metro',
                ],
                [
                    'label' => Yii::t('app', 'Citizenship #accusative#'),
                    'url' => ['/citizenship'],
                    'active' => "/$mId/$cId" === '//citizenship',
                ],
            ],
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Logout ({username})', [
                'username' => Account::current()->username,
            ]),
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>


    <?= $content ?>

</div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endContent(); ?>