<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'common\components\RbacManager',
            'defaultRoles' => ['guest'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i',
            'timeZone' => 'Europe/Moscow',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => null, // stored in local config
            'viewPath' => '@common/mail',
            'messageConfig' => null, // stored in local config
        ],
    ],
];
