
<h1 align="center">Yii2 File Crafter</h1>

Yii2 File Crafter - library for generating a many templates with minimal differences

### Содержание:

- [Setup](#yii2-file-crafter-setup)
- [Config](#yii2-file-crafter-config)
- [Using](#yii2-file-crafter-using)


___

<span id="yii2-file-crafter-setup"></span>
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

<span id="yii2-file-crafter-setup-composer-composer"></span>
<h3>Using: file `composer.json`</h3>

Open file `composer.json`, in section with key `require` add line:  
`"andy87/yii2-file-crafter": "*"`  

dont forget update composer
```bash
composer update
```
<p align="center">- - - - -</p>


<span id="yii2-file-crafter-config"></span>
<h2 align="center">
    Config
</h2>

Config in the configuration file.  
 - basic:`config/(web|web-local|local).php`  
 - advanced:`(frontend|backend)/config/main-local.php`  


Minimum config
```php
 $config['modules']['gii'] = [
    'class' => yii\gii\Module::class,
    'generators' => [
        'fileCrafter' => [
            'class' => Crafter::class,
            'templates' => [
                'group_name' => [
                    // 'template' => 'path/to/file.php',
                    'common/services/PascalCaseService' => 'app/common/services/items/{PascalCase}Service.php',
                    'backend/test/unit/camelCaseService.tpl' => 'backend/test/unit/{{camelCase}}Service.php',
                    'frontend/view/index.php' => 'app/frontend/view/{{snake_case}}/index.php',
                ]
            ]
        ]
    ],
];
```

Full Config with all options
```php
 $config['modules']['gii'] = [
    'class' => yii\gii\Module::class,
    'generators' => [
        'fileCrafter' => [
            'class' => Crafter::class,
            'cache' => [
                'dir' => '@runtime/yii2-file-crafter/cache',
                'ext' => '.tpl'
            ],
            'source' => [
                'dir' => '@runtime/yii2-file-crafter/templates/source',
                'ext' => '.tpl'
            ],
            'custom_fields' => [
                'singular' => 'label - one',
                'plural' => 'label - many',
           ],
            'commands' => [
                'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="app\common\models\sources" --baseClass="app\components\models\BaseModel" --generateRelations --useClassConstant --generateLabelsFromComments'
            ],
            'eventHandlers' => FileCrafterBehavior::class,
            'templates' => [
                'common' => [
                    'common/services/PascalCaseService' => 'app/common/services/items/{[PascalCase]}Service.php',
                ],
                'backend' => [
                    'backend/test/unit/camelCaseService.tpl' => 'backend/test/unit/{{camelCase}}Service.php',
                ],
                'frontend' => [
                    'frontend/view/index.php' => 'app/frontend/view/{{snake_case}}/index.php',
                ],
                'all' => [
                    'common/services/PascalCaseService' => 'app/common/services/items/{PascalCase}Service.php',
                    'backend/test/unit/camelCaseService.tpl' => 'backend/test/unit/{{camelCase}}Service.php',
                    'frontend/view/index.php' => 'app/frontend/view/{{snake_case}}/index.php',
                ]
            ]
        ]
    ],
];
```
--- 



<span id="yii2-file-crafter-using"></span>
<h2>
    Using
</h2>  

- [Marks](#yii2-file-crafter-using-Marks)  
- [Cache](#yii2-file-crafter-using-Cache)  
- [Source](#yii2-file-crafter-using-Source)  
- [Custom](#yii2-file-crafter-using-Custom)  
- [Commands](#yii2-file-crafter-using-Commands)  
- [Events](#yii2-file-crafter-using-Events)  
- [Templates](#yii2-file-crafter-using-Templates)  

--- 


<span id="yii2-file-crafter-using-Marks"></span>  
<h2 align="center">Marks</h2>  

Module use marks for replace variables in templates.  
 - `{{PascalCase}}` - PascalCase by schema name  
 - `{{camelCase}}` - camelCase by schema name  
 - `{{snake_case}}` - snake_case by schema name  
 - `{{kebab-case}}` - kebab-case by schema name  
 - `{{UPPERCASE}}` - UPPERCASE by schema name  
 - `{{lowercase}}` - lowercase  
 - `{{[key]}}` - custom key from property `custom_fields` on `config`  

--- 


<span id="yii2-file-crafter-using-Cache"></span>
<h2 align="center">Cache</h2>  

- `dir` - path to the cache directory with schema data  
- `ext` - extension of the cache file  

--- 


<span id="yii2-file-crafter-using-Source"></span>
<h2 align="center">Source</h2>  

- `dir` - path to the directory with the templates files source for generation  
- `ext` - extension of the templates file  

--- 


<span id="yii2-file-crafter-using-Custom"></span>
<h2 align="center">Custom Fields</h2>  
Array with custom fields for use custom variables in templates.  
Using on template key wrapped in square brackets: `{{%key%}}`  
Example: `{{key_one}}`, `{{key_two}}`...  

Example simple config
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
                'custom_fields' => [
                    'singular' => 'one',
                    'plural' => 'many',
                ],
                'templates' => [
                    'alll' => [
                        'templates' => 'app/frontend/views/info--{{snake_case}}.php',
                    ],
                ],
            ],
        ],
    ];
}
```
with template:
```php
Value - ONE = {{singular}}
Value - MANY = ({{plural}})
```
<p> ___ </p>

Schema 1: `Product Items`  
Field `one` = `!!product!!`  
Field `many` = `>>> products <<<`  

...generate...

Result: `app/frontend/views/info--product_items.php`
```php
Value - ONE = !!product!!
Value - MANY = (>>> products <<<)
```

<p> ___ </p>

Schema 2: `Category Group`  
Field `label one` = `--category--`   
Field `label many` = `+++categories+++`  

...generate...

Result: `app/frontend/views/info--category_group.php`
```php
Value - ONE = --category--
Value - MANY = (+++categories+++)
```

--- 

<span id="yii2-file-crafter-using-Commands"></span>
<h2 align="center">Commands</h2>

Key `commands` contain list `cli` command for call before generate any file.  
command make use of the `{{variable}}` in the command string ( see [Marks](#yii2-file-crafter-using-Marks) )

Example: generate gii model for table name from schema name before generate fileContent
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
                'commands' => [
                    'php ../../yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}}' // ... 
                ],
            ],
        ],
    ];
}
```

<span id="yii2-file-crafter-using-Events"></span>
<h2 align="center">Events</h2>

Make use of the `eventHandlers` key to add a behavior to the module.

Example:
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'eventHandlers' => FileCrafterBehavior::class,
        ],
    ];
}
```


#### Before init
`CrafterEvent::BEFORE_INIT` before init module

#### After init
`CrafterEvent::AFTER_INIT` after init module

Come events has special properties...

#### Before generate
`CrafterEventGenerate::BEFORE` before generate all files

```php
//class FileCrafterBehavior extends Behavior
public function beforeGenerate(CrafterEventGenerate $crafterEventGenerate): void {
    Yii::info([ 'Generated files', [
        $crafterEventGenerate->files // empty (call before generate)
    ]]); 
}
```

#### Before command
`CrafterEventCommand::BEFORE` before run cli command

```php
//class FileCrafterBehavior extends Behavior
public function beforeCommand(CrafterEventCommand $crafterEventCommand): void {
       Yii::error([ __METHOD__, [
        $crafterEventCommand->cmd->exec,
        $crafterEventCommand->cmd->output, // empty (call before exec command)
        $crafterEventCommand->cmd->replaceList
    ]]);
}
```

##### Cmd  
`\andy87\yii2\file_crafter\components\models\Dto`  
 - string **$exec** - _exec command_
 - string **$output** - _exec output_
 - array **$replaceList** - _replace map_

#### After command
`CrafterEventCommand::AFTER` after run cli command

```php
//class FileCrafterBehavior extends Behavior
public function afterCommand(CrafterEventCommand $crafterEventCommand): void {
    Yii::error([ __METHOD__, [
        $crafterEventCommand->cmd->exec,
        $crafterEventCommand->cmd->output, // output command
        $crafterEventCommand->cmd->replaceList
    ]]);
}
```

#### Before render
`CrafterEventRender::BEFORE` before render file

```php
//class FileCrafterBehavior extends Behavior
public function beforeRender(CrafterEventRender $crafterEventRender): void {
    Yii::error([ __METHOD__, [
        $crafterEventRender->schema,
        $crafterEventRender->sourcePath,
        $crafterEventRender->generatePath,
        $crafterEventRender->replaceList,
        $crafterEventRender->content // empty (call before render file)
    ]]);
}
```

#### After render
`CrafterEventRender::AFTER` after render file

```php
//class FileCrafterBehavior extends Behavior
public function afterRender(CrafterEventRender $crafterEventRender): void {
    Yii::error([ __METHOD__, [
        $crafterEventRender->schema,
        $crafterEventRender->sourcePath,
        $crafterEventRender->generatePath,
        $crafterEventRender->replaceList,
        $crafterEventRender->content // content file
    ]]);
}
```

#### After generate
`CrafterEventGenerate::AFTER` after generate all files

```php
public function afterGenerate(CrafterEventGenerate $crafterEventGenerate): void {
    Yii::info([ 'Generated files', [
        $crafterEventGenerate->files // CodeFile[]
    ]]); 
}
```

--- 

<span id="yii2-file-crafter-using-Templates"></span>
<h2 align="center">Templates</h2>

Content of the templates file rendered with the `View` method `renderFile`  
`$this->renderFile($sourcePath)`  
 - `$sourcePath` - path to the source file

And prepared with the `$replaceList` array contains all marks. ( see [Marks](#yii2-file-crafter-using-Marks) )

___

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
