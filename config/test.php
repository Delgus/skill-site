<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru',
    'name' => 'Прокачайся!!!',
    'components' => [
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::class,
            'clients' => [
                // here is the list of clients you want to use
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6470874',
                    'clientSecret' => 'fUjhcMMWlpecHhqtakCo',
                ],
                /* 'facebook' => [
                     'class' => 'yii\authclient\clients\Facebook',
                     'clientId' => 'facebook_client_id',
                     'clientSecret' => 'facebook_client_secret',
                 ],
                 'google' => [
                     'class' => 'yii\authclient\clients\Google',
                     'clientId' => 'google_client_id',
                     'clientSecret' => 'google_client_secret',
                 ],
                 'yandex' => [
                     'class' => 'yii\authclient\clients\Yandex',
                     'clientId' => 'yandex_client_id',
                     'clientSecret' => 'yandex_client_secret'
                 ],*/
            ],
        ],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Sh26_R7m6uDa2B9XsliAy1lKqFezddi7',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\modules\user\components\UserConfig',

            // Comment this if you don't want to record user logins
            'on afterLogin' => function ($event) {
                app\modules\user\models\UserVisitLog::newVisitor($event->identity->id);
            }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'blog' => [
            'class' => app\modules\blog\Blog::class,
            'on beforeAction' => function ($event) {
                if ($event->action->controller->id != 'default') {
                    $event->action->controller->attachBehavior('ghostAccess',
                        app\modules\user\components\GhostAccessControl::class);
                }
            },
        ],
        'surver' => [
            'class' => app\modules\surver\Module::class,
            'userView' => '/user/user/view',
            'wysiwyg' => [
                'class' => 'dosamigos\ckeditor\CKEditor',
                'config' => [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ],
            ],
            'as ghostAccess' => [
                'class' => 'app\modules\user\components\GhostAccessControl',
            ],
        ],
        'user' => [
            'class' => 'app\modules\user\UserManagementModule',
            'enableRegistration' => true,
        ],
    ],
    'params' => $params,
];

