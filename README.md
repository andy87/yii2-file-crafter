
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
    'class' => 'yii\gii\Module',
    'generators' => [
        'fileCrafter' => [
            'class' => \andy87\yii2\dnk_file_crafter\Crafter::class,
            'mode' => Model::ADVANCED, // basic|advanced
            'dir' => [
                Dir::CACHE => '@runtime/dnk-file-crafter/cache',
                Dir::MIGRATION => '@vendor/andy87/yii2-dnk-file-crafter/src/templates/migration',
                Dir::CUSTOM => '@vendor/andy87/yii2-dnk-file-crafter/src/templates/custom',
            ],
            'params' => [
                Params::CRUD => [
                    CrudParams::MODEL_CLASS => '',
                    CrudParams::SEARCH_MODEL_CLASS => '',
                    CrudParams::CONTROLLER_CLASS => '',
                    CrudParams::VIEW_PATH => '',
                    CrudParams::BASE_CONTROLLER_CLASS => '',
                    CrudParams::VIEW_WIDGET => '',
                    CrudParams::ENABLE_I18N => '',
                    CrudParams::ENABLE_PJAX => '',
                    CrudParams::CODE_TEMPLATE => '',
                ],
                Params::DNK => [
                    DnkParams::MAPPING => [],
                ],
]
            ]
        ],
    ],
];
```



[Packagist](https://packagist.org/packages/andy87/yii2-dnk-file-crafter)
