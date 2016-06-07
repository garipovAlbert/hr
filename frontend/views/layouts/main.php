<?php
/* @var $this View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?= Html::csrfMetaTags() ?>
        <title><?= $this->title ? Html::encode($this->title) : Yii::$app->name ?></title>

        <?php $this->head() ?>

        <link href="/static-assets/css/bootstrap/css/bootstrap.css" media="all" rel="stylesheet">

        <link href="/static-assets/css/normalize.css" media="all" rel="stylesheet">

        <link href="/static-assets/css/style.css" media="all" rel="stylesheet">




        <!--[if lte IE 8]>
            <script src="/static-assets/js/selectivizr.js"></script>
            <script src="/static-assets/js/respond.js"></script>
        <![endif]-->
        <!--[if IE]><![endif]-->
        <link href="/static-assets/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>

        <script type="text/javascript">
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-50718706-1', 'auto');
            ga('send', 'pageview');
        </script>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">

    </head>

    <body class="static_page" id="apply_page">
        <?php $this->beginBody() ?>
        <div class="header">
            <div class="header_inside container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row text-center">
                            <a href="http://www.karofilm.ru/">
                                <img alt="Logo white" src="/static-assets/images/logo_white.png"/>
                            </a>
                        </div>
                        <div class="row text-center">
                            <h1 class="first_label">Присоединяйся к команде КАРО!</h1>
                        </div>
                        <div class="row text-center">
                            <?php
                            echo Menu::widget([
                                'items' => [
                                    ['label' => 'Карьера в КАРО', 'url' => ['site/job']],
                                    ['label' => 'Мы предлагаем', 'url' => ['site/we-offer']],
                                    ['label' => 'Заполнить анкету', 'url' => ['site/index']],
                                ],
                                'options' => ['class' => 'menu'],
                            ]);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full_screen">
            <div class="container">
                <p class="notice alert alert-success" style="display: none;"></p>
            </div>
        </div>
        <div class="full_screen">
            <div class="container">
                <p class="alert alert-danger" style="display: none;"></p>
            </div>
        </div>
        <div class="wrapper container">
            <?= $content ?>

            <?php if (YII_ENV_PROD): ?>
                <script type="text/javascript">
                    (function (d, w, c) {
                        (w[c] = w[c] || []).push(function () {
                            try {
                                w.yaCounter25495793 = new Ya.Metrika({id: 25495793, webvisor: true});
                            } catch (e) {
                            }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () {
                                n.parentNode.insertBefore(s, n);
                            };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f, false);
                        } else {
                            f();
                        }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript>&lt;div&gt;&lt;img src="//mc.yandex.ru/watch/" style="position:absolute; left:-9999px;" alt="" /&gt;&lt;/div&gt;</noscript>
            <?php endif; ?>

        </div>
        <div class="container development">&nbsp;</div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>