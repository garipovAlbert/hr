<?php
$params = call_user_func_array('array_merge', [
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
]);

return [
    'class' => 'backend\components\Application',
    'name' => 'Karo HR admin',
    'sourceLanguage' => 'en-US',
    'language' => 'ru-RU',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'publicRoutes' => [
        'site/login',
        'site/error',
        'site/logout',
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Account',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'common\components\BackendUrlManager',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'session' => [
            'name' => 'karohr_' . YII_ENV,
        ],
    ],
    'params' => $params,
];
