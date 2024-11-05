<?php

use andy87\yii2\file_crafter\Crafter;

$config = [];

if (YII_ENV_DEV)
{
    $mapping = require __DIR__ . '/../mapping.php';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'fileCrafter' => [
                'class' => Crafter::class,
                'params' => [
                    'cache' => [
                        'dir' => '@console/runtime/andy87/yii2-file-crafter/cache',
                        'ext' => '.json'
                    ],
                    'source' => [
                        'dir' => '@console/runtime/andy87/yii2-file-crafter/templates/source',
                        'ext' => '.tpl',
                    ],
                    'custom_fields' => [
                        'singular' => 'Ед. число',
                        'plural' => 'Мн. число',
                    ],
                ],
                'templates' => [
                    'common' => $mapping['common'],
                    'console' => $mapping['console'],
                    'frontend' => $mapping['frontend'],
                    'backend' => $mapping['backend'],
                    'all' => [
                        ...$mapping['common'],
                        ...$mapping['console'],
                        ...$mapping['frontend'],
                        ...$mapping['backend'],
                    ],
                ],
            ],
        ],
    ];
}

return $config;