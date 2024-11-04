
<h1 align="center">Yii2 File Crafter</h1>

Yii2 File Crafter - library for generating a many templates with minimal differences

### Содержание:

- [Setup](#yii2-dnk-file-crafter-setup)
- [Config](#yii2-dnk-file-crafter-config)
- [Using](#yii2-dnk-file-crafter-setup-composer-composer-use)


___

<span id="yii2-migrate-architect-setup"></span>
<h2 align="center">
Setup
</h2>

<span id="yii2-migrate-architect-setup-require"></span>
<h3>Requirements</h3> 

- php >=8.0
- Yii2

<h3>
    <a href="https://getcomposer.org/download/">Composer</a>
</h3>

<span id="yii2-migrate-architect-setup"></span>
## Add package to project

<h3>Using console</h3>
<small><i>(Recommended)</i></small>

- Composer ( global setup )
```bash
composer require andy87/yii2-file-crafter
````  
- Composer.phar ( local setup )
```bash
php composer.phar require andy87/yii2-file-crafter
```

<span id="yii2-dnk-file-crafter-setup-composer-composer"></span>
<h3>Using: file `composer.json`</h3>

Open file `composer.json`, in section with key `require` add line:  
`"andy87/yii2-dnk-file-crafter": "*"`  


<p align="center">- - - - -</p>


<span id="yii2-migrate-architect-config"></span>
<h2 align="center">
    Config
</h2>

Config in the configuration file.
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
                'bash' => [
                    'php yii gii/model
                    --tableName={{snake_case}}
                    --modelClass={{PascalCase}}
                    --ns="app\common\models\sources"
                    --baseClass="app\components\models\BaseModel"
                    --generateRelations
                    --useClassConstant
                    --generateLabelsFromComments'
                ]
            ],
            'templates' => [
                'common' => [
                    'common/services/PascalCaseService' => 'app/common/services/items/{[PascalCase]}Service',
                ],
                'backend' => [
                    'backend/test/unit/camelCaseService' => 'backend/test/unit/{camelCase}Service',
                ],
                'frontend' => [
                    'frontend/view/index.php' => 'app/frontend/view/{{snake_case}}/index',
                ],
                'all' => [
                    'common/services/PascalCaseService' => 'app/common/services/items/{PascalCase}Service',
                    'backend/test/unit/camelCaseService' => 'backend/test/unit/{camelCase}Service',
                    'frontend/view/index.php' => 'app/frontend/view/{{snake_case}}/index',
                ]
            ]
        ]
    ],
];
```

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
