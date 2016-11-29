<?php
$params = require(__DIR__ . '/params.php');
$routes = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/routes.php'),
    require(__DIR__ . '/../modules/mailTemplate/config/routes.php')
);

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
        'db' => require(__DIR__ . '/test_db.php'),
        'mailer' => [
            'useFileTransport' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
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
                    'basePath' => '@app/messages',
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
            'class' => 'app\modules\mailTemplate\MailTemplate',
        ],
    ],
    'params' => $params,
];
