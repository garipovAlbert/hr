<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?= Html::csrfMetaTags() ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Авторизация</title>
        <link rel="stylesheet" href="/login/bootstrap.min.css">
        <link rel="stylesheet" href="/login/site.css">
        <link rel="stylesheet" href="/login/login.css">
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="site-login">
            <h1>KARO Digital Recruitment System</h1>
            <div class="row">
                <div class="col-xs-12 col-sm-5">
                    <?= $content ?>
                </div>
                <div class="col-xs-12 col-sm-7 copy">
                    <p>Copyright KARO Film Management 2016. All rights reserved</p>
                    <p>Version: 1.0.1</p>
                </div>
            </div>

        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>