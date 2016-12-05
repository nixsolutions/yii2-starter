<?php
$params = require(__DIR__ . '/params.php');
$routes = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/../modules/mailTemplate/config/routes.php'),
    require(__DIR__ . '/../modules/user/config/routes.php')
);

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
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
            'loginUrl'=>['/login'],
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
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
                'mailing' => [
                    'class' => 'yii\i18n\GettextMessageSource',
                    'basePath' => '@app/modules/mailing/messages',
                    'sourceLanguage' => 'en_US',
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
    ],
    'params' => $params,
];
