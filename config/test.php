<?php
$params = require(__DIR__ . '/params.php');
$routes = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/../modules/mailTemplate/config/routes.php'),
    require(__DIR__ . '/../modules/user/config/routes.php'),
    require(__DIR__ . '/../modules/feedback/config/routes.php'),
    require(__DIR__ . '/../modules/page/config/routes.php')
);
$clients = require(__DIR__ . '/clients.php');

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'option'],
    'aliases' => [
        '@bower' => '@vendor/bower',
    ],
    'language' => 'en-US',
    'components' => [
        'assetManager' => [
            'linkAssets' => YII_ENV_DEV ? true : false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => require(__DIR__ . '/test_db.php'),
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => true,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'i18n' => [
            'translations' => [
                'site' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en_US',
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' =>$clients,
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'mailTemplate' => [
            'class' => 'app\modules\mailTemplate\Module',
        ],
        'page' => [
            'class' => 'app\modules\page\Module',
        ],
        'option' => [
            'class' => 'app\modules\option\Module',
        ],
        'feedback' => [
            'class' => 'app\modules\feedback\Module',
        ],
    ],
    'params' => $params,
];
