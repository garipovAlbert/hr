<?php

use frontend\assets\AppAsset;
use yii\helpers\Url;

header('Content-Type: text/html; charset=utf-8');
$rand = rand(1, 3);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Каро :: HR</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no" />
        <!--<link href="https://yastatic.net/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <!--<link href="/css/bootstrap.min.css" rel="stylesheet">-->
        <link href="/js/owl/assets/owl.carousel.css" rel="stylesheet">
        <link href="/css/header.css" rel="stylesheet">
        <link href="/css/footer.css" rel="stylesheet">
        <link href="/css/page.css?v=2" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600&amp;subset=latin,cyrillic" rel="stylesheet">
        <link href="/js/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="/js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet">
        
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

        <?php $this->head() ?>

        <link href="/static-assets/css/bootstrap/css/bootstrap.css" media="all" rel="stylesheet">
        <link href="/static-assets/css/style.css?v=2" media="all" rel="stylesheet">

    </head>
    <body class="static_page" id="apply_page" style="background-image: url(/img/bg/img<?= $rand ?>.png)">
        <div class="overlay"></div>
        <div class="wrap">
            <div id="header" class="container-fluid">
                <div class="row">
                    <a class="pull-left" id="logo" href="https://karofilm.ru">
                        <img alt="" src="/img/logo.png" class="white">
                    </a>
                    <a class="pull-left art-link hidden-sm hidden-xs" href="https://karofilm.ru/theatres">
                        <span>Кинотеатры</span>
                    </a>
                    <a class="pull-left art-link hidden-xs" href="https://karofilm.ru/art">
                        <span>АРТ</span>
                    </a>
                    <a class="pull-left art-link hidden-xs" href="/">
                        <span>КИНО.класс</span>
                    </a>
                </div>
            </div>
            <div class="content container-fluid">
                <div id="page-content" class="row">
                    <div class="top-nav">
                        <!-- Nav tabs -->
                        <?php $r = Yii::$app->controller->route; ?>
                        <div class="btn-group" data-toggle="btns">
                            <a href="<?= Url::to(['site/job']) ?>" class="btn btn-default<?= $r == 'site/job' ? ' active' : '' ?>">Карьера в КАРО</a>
                            <a href="<?= Url::to(['site/we-offer']) ?>" class="btn btn-default<?= $r == 'site/we-offer' ? ' active' : '' ?>">Мы предлагаем</a>
                            <a href="<?= Url::to(['site/index']) ?>" class="btn btn-default<?= $r == 'site/index' ? ' active' : '' ?>">Заполнить заявку</a>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content container">

                        <div role="tabpanel" class="tab-pane fade row in active" id="application">
                            <?= $content ?>
                        </div>

                    </div>
                </div>
            </div>
            <div id="footer" class="container-fluid">
                <div class="row">
                    <a class="footer-logo col-xs-12 col-sm-12 col-md-2">
                        <img src="/img/logo-footer.png" alt="">
                    </a>
                    <div class="footer-content col-xs-12 col-sm-12 col-md-10">
                        <div class="foo-nav row">
                            <ul id="foo-menu" class="foo-menu">
                                <li><a href="https://karofilm.ru/theatres">Кинотеатры</a></li>
                                <li><a href="https://karofilm.ru/premiere">Премьеры</a></li>
                                <li><a href="https://karofilm.ru/news">Новости</a></li>
                                <li><a href="http://hr.karofilm.ru">Вакансии</a></li>
                                <li><a href="https://karofilm.ru/site/contacts">Контакты</a></li>
                            </ul>
                        </div>
                        <div class="foo-info row">
                            <ul class="foo-social col-xs-6 col-md-5">
                                <li><a class="m-fb" target="_blank" href="https://www.facebook.com/karofilm"></a></li>
                                <li><a class="m-vk" target="_blank" href="http://vk.com/karofilm_vk"></a></li>
                                <li><a class="m-od" target="_blank" href="http://www.odnoklassniki.ru/karofilm"></a></li>
                                <li><a class="m-in" href="http://instagram.com/karocinema" target="_blank"></a></li>
                                <li><a class="m-tw" href="https://twitter.com/karo_film" target="_blank"></a></li>
                                <li class="clear"></li>
                            </ul>
                            <div class="col-xs-12 col-md-5">
                                <p>Все права защищены</p>
                                <!--<p>Сайт разработан <a href="">terrabo_</a></p>-->
                                <p>&copy; 2007-<?= date('Y', time()) ?> «КАРО Фильм Менеджмент»</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endBody() ?>

<!--<script src="https://yastatic.net/jquery/2.2.3/jquery.min.js"></script>-->
<!--<script src="https://yastatic.net/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
        <script src="/js/fancybox/source/jquery.fancybox.pack.js"></script>
        <script src="/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
        <script src="/js/fancybox/source/helpers/jquery.fancybox-media.js"></script>
        <script src="/js/fancybox/source/helpers/jquery.fancybox-buttons.js"></script>
        <script src="/js/owl/owl.carousel.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/nicescroll/jquery.nicescroll.min.js"></script>
        <script type="text/javascript">jQuery(document).ready(function () {
                var isMobile = {
                    Android: function () {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function () {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function () {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function () {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function () {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function () {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };
                $(document).ready(function () {
                    if (!isMobile.any()) {
                        $(document).on('mouseover', '.afisha-item', function (e) {
                            if ($(window).width() >= 639) {
                                $(this).find('.afisha-preview-blur').removeClass('blur');
                                $(this).addClass('hover');
                            }
                        });
                        $(document).on('mouseout', '.afisha-item', function (e) {
                            if ($(window).width() >= 639) {
                                $(this).find('.afisha-preview-blur').addClass('blur');
                                $(this).removeClass('hover');
                            }
                        });
                    } else {
                        $('.afisha-btn').bind('touchstart touchend', function (e) {
                            $(this).toggleClass('hover_effect');
                        });
                        $('.afisha-item').click(function (e) {
                            if (!$(this).is('.hover')) {
                                if ($(window).width() >= 639 && !$(this).is('.hover')) {
                                    e.preventDefault();
                                    $('.afisha-item.hover').removeClass('hover');
                                    $(this).addClass('hover');
                                }
                            }
                        });
                    }
                    if ($('.branding-slide').length > 1) {
                        $('.slider-branding:first').bxSlider({
                            mode: 'horizontal',
                            //randomStart     :   true,
                            auto: true,
                            pause: 9000,
                            slideMargin: 0,
                            slideSelector: 'a.branding-slide',
                            responsive: true,
                            pager: true,
                            adaptiveHeight: true
                        });
                    }
                    $(document).on('click', '.afisha-player', function (e) {
                        e.preventDefault();
                        var href = $(this).attr('href'),
                            title = $(this).attr('data-title');
                        if (!$(this).parent().parent().is('.hover')) {
                            $.fancybox.open({
                                href: href,
                                title: title,
                                type: 'iframe',
                                padding: 0,
                                'scrolling': 'no',
                                iframe: {
                                    scrolling: 'no'
                                },
                                beforeShow: function () {
                                    $('.fancybox-inner').css('overflow', 'hidden');
                                },
                                afterLoad: function () {
                                    $('.fancybox-inner').css('overflow', 'hidden');
                                },
                                afterShow: function () {
                                    $('.fancybox-inner').css('overflow', 'hidden');
                                },
                                helpers: {
                                    overlay: {
                                        css: {
                                            'background': 'rgba(0, 0, 0, 0.75)'
                                        }
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>

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


    </body>
</html>
<?php $this->endPage() ?>