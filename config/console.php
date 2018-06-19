<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager'  => [
            'class'        => 'yii\rbac\DbManager',
        ],
        'db' => $db,
    ],
    'params' => $params,
    'modules'=>[
        'user' => [
            'class' => 'app\modules\user\UserManagementModule',
        ],
    ],
    'controllerMap' => [
    	'fixture' => [
            'class' => 'yii\faker\FixtureController',
        ],
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                'modules/user/migrations/', // Миграции модуля user-management
                'modules/surver/migrations', //Миграции модуля с тестами-опросниками
                'modules/blog/migrations', //Мигграции модуля блога
                'migrations/',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
