<?php

$params = require(__DIR__ . '/params.php');
$routes = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/../modules/mailTemplate/config/routes.php'),
    require(__DIR__ . '/../modules/user/config/routes.php'),
    require(__DIR__ . '/../modules/page/config/routes.php')
);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'bLuSJS-EnGQOxVJRARHg9WzzV8RhMeAe',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => require(__DIR__ . '/mailer.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'i18n' => [
            'translations' => [
                'mailTemplate' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/modules/mailTemplate/messages',
                    'sourceLanguage' => 'en_US',
                ],
                'user' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/modules/user/messages',
                    'sourceLanguage' => 'en_US',
                ],
                'site' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en_US',
                ],
                'mailing' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/modules/mailing/messages',
                    'sourceLanguage' => 'en_US',
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '937683696362218',
                    'clientSecret' => '46b5d7dfbb3533ca477e924bb726117d',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '249379371436-p3116lvshu2c5f3jojasnj6otdh5436p.apps.googleusercontent.com',
                    'clientSecret' => 'QCnauGkhZbyu3j5x8IK0xyLM',
                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => 'g84sIfCGtkkiKeRAD6UFl8l6Y',
                    'consumerSecret' => 'MfeYrhj5fi5XaaG5Gq1sbzHFleDWpNVewVdcxcXKlPXiW307aq',
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'mailTemplate' => [
            'class' => 'app\modules\mailTemplate\Module',
        ],
        'mailing' => [
            'class' => 'app\modules\mailing\Module',
        ],
        'page' => [
            'class' => 'app\modules\page\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['192.168.10.1'],
    ];
}

return $config;
