<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'urn:nightswatch:v3:console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'TheNightsWatch\Core\Command',
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                'TheNightsWatch\Player\Migration',
                'TheNightsWatch\Election\Migration',
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => require(__DIR__ . '/modules.php'),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return array_merge_recursive(require('global.php'), $config);
