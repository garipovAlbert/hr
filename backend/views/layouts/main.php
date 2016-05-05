<?php

use backend\widgets\Alert;
use common\models\Account;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\Application;
use yii\web\View;
use yii\widgets\Breadcrumbs;

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
        'brandLabel' => Yii::t('app', 'Karo HR Backend'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => Yii::t('app', 'Applications'),
            'url' => ['/application'],
            'active' => "$mId/$cId" === '//application',
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Show Report'),
            'url' => ['/report'],
            'active' => "/$mId/$cId" === '//report',
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Instructions / Files'),
            'url' => ['/info'],
            'active' => "/$mId/$cId" === '//info',
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Manage Accounts'),
            'url' => ['/account'],
            'active' => "/$mId/$cId" === '//account',
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Add'),
            'items' => [
                [
                    'label' => Yii::t('app', 'Cinema'),
                    'url' => ['/cinema'],
                    'active' => "/$mId/$cId" === '//cinema',
                ],
                [
                    'label' => Yii::t('app', 'Vacancy'),
                    'url' => ['/vacancy'],
                    'active' => "/$mId/$cId" === '//vacancy',
                ],
                [
                    'label' => Yii::t('app', 'City'),
                    'url' => ['/city'],
                    'active' => "/$mId/$cId" === '//city',
                ],
                [
                    'label' => Yii::t('app', 'Metro'),
                    'url' => ['/metro'],
                    'active' => "/$mId/$cId" === '//metro',
                ],
                [
                    'label' => Yii::t('app', 'Citizenship'),
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


    <div class="container-fluid">

        <div class="col-md-12 well content-area">
            <?=
            Breadcrumbs::widget([
                'homeLink' => false,
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>

            <?= Alert::widget() ?>

            <?= $content ?>
        </div>

    </div>

</div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endContent(); ?>