<?php declare(strict_types=1);

use yii\gii\Module;
use andy87\yii2\file_crafter\Crafter;

$config = [];

if (YII_ENV_DEV)
{
    $mapping = require __DIR__ . '/../mapping.php';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
                'class' => Crafter::class,
                'cache' => [
                    'dir' => '@console/runtime/andy87/yii2-file-crafter/cache',
                    'ext' => '.json'
                ],
                'source' => [
                    'dir' => '@console/runtime/andy87/yii2-file-crafter/templates/source',
                    'ext' => '.tpl',
                ],
                'commands' => [
                    'php ../../yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="app\common\models\sources" --baseClass="app\common\components\core\BaseModel" --generateRelations --useClassConstant --generateLabelsFromComments'
                ],
                'eventHandler' => FileCrafterBehavior::class,
                'custom_fields' => [
                    'singular' => 'Ед. число',
                    'plural' => 'Мн. число',
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