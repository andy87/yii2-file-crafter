
<h1 align="center">Yii2 migrate architect</h1>

Yii2 migrate architect - библиотека для фреймворка Yii2 упрощающая написание кода миграций. 

Цель: сделать простой и быстрый инструмент добавления миграций.

### Содержание:

- [Установка](#yii2-dnk-file-crafter-setup)
- [Настройка](#yii2-dnk-file-crafter-config)
- [Использование](#yii2-dnk-file-crafter-setup-composer-composer-use)


___

<span id="yii2-migrate-architect-setup"></span>
<h2 align="center"> 
    Установка
</h2>

<span id="yii2-migrate-architect-setup-require"></span>
<h3>Требования</h3> 

- php >=8.0
- Yii2

<h3>
    <a href="https://getcomposer.org/download/">Composer</a>
</h3>

<span id="yii2-migrate-architect-setup"></span>
## Добавление пакета в проект

<h3>Используя консоль</h3>
<small><i>(Предпочтительней)</i></small>

- Composer, установленный локально
```bash
composer require andy87/yii2-dnk-file-crafter
````  
- Composer.phar
```bash
php composer.phar require andy87/yii2-dnk-file-crafter
```

<span id="yii2-dnk-file-crafter-setup-composer-composer"></span>
<h3>Используя: файл `composer.json`</h3>

Открыть файл `composer.json`,  
в раздел с ключём `require` добавить строку:  
`"andy87/yii2-dnk-file-crafter": "*"`  


<p align="center">- - - - -</p>


<span id="yii2-migrate-architect-config"></span>
<h2 align="center">
    Настройка
</h2>

Настройки в конфигурационном файле.  CrudParams::
 - basic:`config/(web|web-local|local).php`
 - advanced:`(frontend|backend)/config/main-local.php`

```php
 $config['modules']['gii'] = [
    'class' => yii\gii\Module::class,
    'generators' => [
        'fileCrafter' => [
            'class' => Crafter::class,
            'params' => [
                'cache' => [
                    'dir' => '@runtime/andy87/yii2-dnk-file-crafter/cache',
                    'ext' => '.tpl'
                ],
                'source' => [
                    'dir' => '@runtime/andy87/yii2-dnk-file-crafter/templates/source',
                    'ext' => '.tpl'
                ],
                'custom_fields' => [
                    'singular' => 'Ед. число', // {{singular}}
                    'plural' => 'Мн. число', // {{plural}}
               ],
                'crud' => [
                    'modelClass' => 'app\models\source\{PascalCase}',
                    'searchModelClass' => 'app\common\models\source\{PascalCase}',
                    'controllerClass' => 'app\backend\controllers\source\{PascalCase}Controller',
                    'viewPath' => '@backend\source\{snake_case}',
                    'baseControllerClass' => 'app\backend\components\controllers\BackendController',
                    'viewWidget' => Crafter::VIEW_WIDGET_GRID_VIEW,
                    'enableI18n' => false,
                    'enablePjax' => false,
                    'codeTemplate' => 'default',
                ]
            ],
            'templates' => [
                'default' => 'all',
                'common' => [
                    'common/services/ItemService' => 'app/common/services/items/{PascalCase}Service',
                ],
                'console' => [
                    'console/controllers/ItemController' => 'app/console/controllers/{PascalCase}Controller',
                    'console/services/ItemService' => 'app/console/services/{PascalCase}Service',
                    'console/tests/unit/services/ItemServiceTest' => 'app/console/tests/unit/services/{PascalCase}ServiceTest',
                ],
                'frontend' => [
                'frontend/controllers/ItemController' => 'app/frontend/controllers/{PascalCase}Controller',
                    'frontend/views/item/index' => 'app/frontend/views/{snake_case}/index',
                    'frontend/services/ItemService' => 'app/frontend/services/items/{PascalCase}Service',
                    'frontend/tests/functional/ItemControllerCest' => 'app/frontend/tests/functional/{PascalCase}ControllerCest',
                ],
                'backend' => [
                    'backend/controllers/ItemController' => 'app/backend/controllers/{PascalCase}Controller',
                    'backend/views/item/index' => 'app/backend/views/{snake_case}/index',
                    'backend/services/ItemService' => 'app/backend/services/items/{PascalCase}Service',
                ],
                'all' => [
                    'common/services/ItemService' => 'app/common/services/items/{PascalCase}Service',

                    'console/services/ItemService' => 'app/console/services/{PascalCase}Service',

                    'frontend/controllers/ItemController' => 'app/frontend/controllers/{PascalCase}Controller',
                    'frontend/views/item/index' => 'app/frontend/views/{snake_case}/index',
                    'frontend/services/ItemService' => 'app/frontend/services/items/{PascalCase}Service',
                    'frontend/tests/functional/ItemControllerCest' => 'app/frontend/tests/functional/{PascalCase}ControllerCest',

                    'backend/controllers/ItemController' => 'app/backend/controllers/{PascalCase}Controller',
                    'backend/views/item/index' => 'app/backend/views/{snake_case}/index',
                    'backend/services/ItemService' => 'app/backend/services/items/{PascalCase}Service',
                ]
            ]
        ]
    ],
];
```


[Packagist](https://packagist.org/packages/andy87/yii2-dnk-file-crafter)
