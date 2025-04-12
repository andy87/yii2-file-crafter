
<h1 align="center">Yii2 File Crafter</h1>

Yii2 File Crafter - library for generating a many templates with minimal differences

### Content

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
composer require andy87/yii2-file-crafter:dev-master --dev
````  
- Composer.phar ( local setup )
```bash
php composer.phar require andy87/yii2-file-crafter:dev-master --dev
```

<span id="yii2-file-crafter-setup-composer-composer"></span>
<h3>Using: file `composer.json`</h3>

Open file `composer.json`, in section with key `require` add line:  
`"andy87/yii2-file-crafter": "dev-master"`  

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
            'class' => andy87\yii2\file_crafter\Crafter::class,
            'options' => [
                'templates' => [
                    'group_name' => [
                        // 'template' => 'path/to/file.php',
                        'common/services/PascalCaseService' => '@app/common/services/items/{PascalCase}Service.php',
                        'template/test/unit/camelCaseService.tpl' => '@backend/test/unit/{{camelCase}}Service.php',
                        'templates/view/index.php' => 'custom/dir/{{snake_case}}/index.php',
                    ]
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
            'class' => andy87\yii2\file_crafter\Crafter::class,
            'options' => [
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
                    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0' //... 
                ],
                'eventHandler' => app\composents\behavior\FileCrafterBehavior::class,
                'autoCompleteStatus' => true,
                'autoCompleteList' => [
                    'autocomplete name 1',
                    'autocomplete name 2',
                ],
                'previewStatus' => true,
                'canDelete' => true,
                'parseDataBase' => ['autocomplete','fakeCache'],
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
                ],
            ]
        ]
    ],
];
```

<span id="yii2-file-crafter-using"></span>
<h2>
    Using
</h2>  

- [Marks](#yii2-file-crafter-using-Marks)  
- [Cache](#yii2-file-crafter-using-Cache)  
- [Source](#yii2-file-crafter-using-Source)  
- [Custom Fields](#yii2-file-crafter-using-CustomFields)  
- [Autocomplete status](#yii2-file-crafter-autoCompleteStatus)
- [Autocomplete list](#yii2-file-crafter-autoCompleteList)
- [Preview status](#yii2-file-crafter-previewStatus)
- [Can delete](#yii2-file-crafter-canDelete)
- [Parse data base](#yii2-file-crafter-parseDataBase)
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
 - `{{lowercase}}` - lowercase by schema name
 - `{{[key]}}` - custom key from property `custom_fields` on `config` ( see [Custom Fields](#yii2-file-crafter-using-Custom) )

#### Example
for schema name `Product Items` replace marks:
- `{{PascalCase}}` - `ProductItems`  
- `{{camelCase}}` - `productItems`  
- `{{snake_case}}` - `product_items`  
- `{{kebab-case}}` - `product-items`  
- `{{UPPERCASE}}` - `PRODUCT ITEMS`  
- `{{lowercase}}` - `product items`  

--- 

<span id="yii2-file-crafter-using-Cache"></span>
<h2 align="center">
    Cache
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>  

Configuration for the cache folder with schema data.

- `dir` - path to the cache directory with schema data  
- `ext` - extension of the cache file  

Default configuration:
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'cache' => [
                    'dir' => '@runtime/yii2-file-crafter/cache',
                    'ext' => '.json'
                ],
                // ...
            ],
        ],
    ]
];
```


--- 

<span id="yii2-file-crafter-using-Source"></span>
<h2 align="center">
    Source
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>  

Configuration for the source folder with templates files.

- `dir` - path to the directory with the templates files source for generation  
- `ext` - extension of the templates file  

Default configuration:
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'source' => [
                    'dir' => '@runtime/yii2-file-crafter/templates/source',
                    'ext' => '.tpl'
                ],
                // ...
            ],
        ],
    ]
];
```

--- 
<span id="yii2-file-crafter-using-CustomFields"></span>
<h2 align="center">
    Templates
    <small style="color: #900; font-size:9px">(required)</small>
</h2>

Array with groups of templates for use on generate files.  
```php
[
    ['group1'] => [
        'template1' => 'path/from/project/root/to/resultFile.tpl',
        'template2.tpl' => 'path/from/project/root/to/resultFile.php',
        // ...
    ],
    ['group2'] => [
        'template1.php' => '@path/alias/to/resultFile.tpl',
        '@alias/to/template' => 'path/from/project/root/to/resultFile.php',
        // ...
    ],
]
```
The source path may contain:  
 - some `@` alias ( `source['dir']` - default container )  
 - `ext` for generate any file type ( `.php` default )  
 - some `{{variable}}` ( see [Marks](#yii2-file-crafter-using-Marks) )  

File source-template will be searched in the `source` folder.  
Source folder path can be set in the configuration file. ( see [Source](#yii2-file-crafter-using-Source) )  

The resultFile path may contain:  
 - some `@` alias ( `@app/` - default prefix )  
 - `ext` for generate any file type ( `.php` default )  
 - some `{{variable}}` ( see [Marks](#yii2-file-crafter-using-Marks) )  

Content of the templates file rendered with the `View` method `renderFile`  
And prepared with the `$replaceList` array contains all marks. ( see [Marks](#yii2-file-crafter-using-Marks) )  
And also passed to the render method:  
 - `$schema` - schema object  
 - `$generator` - self generator object

```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'templates' => [
                    'all' => [
                        '@backend/dir/by/alias/camelCaseService.tpl' => '@backend/generate/by/alias/{{camelCase}}Service.php',
                        'dir/on/source/dir/generate_file' => 'custom/dir/on/source/dir/{{snake_case}}/generate_file.tpl',
                    ],
                ],
                // ...
            ],
        ],
    ]
];
```

---

<span id="yii2-file-crafter-using-CustomFields"></span>
<h2 align="center">
    Custom Fields
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>  

Array with custom fields for use custom variables in templates.  
Using on template key wrapped in square brackets: `{{%key%}}`    
Example: `{{key_one}}`, `{{key_two}}`...  

Example simple config  
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'custom_fields' => [
                    'singular' => 'one',
                    'plural' => 'many',
                ],
                // ...
            ],
        ],
    ]
];
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

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>
<h2 align="center">Autocomplete status</h2>

Key `autoCompleteStatus` contain status for autocomplete field `Schema name` in the form 200 populated values.
  
Variants: `true` or `false`(default)  
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'autoCompleteStatus' => true,
                // ...
            ],
        ],
    ],
];
```

--- 

<span id="yii2-file-crafter-using-autoCompleteList"></span>
<h2 align="center">
    Autocomplete list
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>

Key `autoCompleteList` contain list of autocomplete field `Schema name` in the form self custom list.
  
Type: `array`  
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'autoCompleteList' => [
                    'Product Items',
                    'Category Group',
                    'User Profile',
                    // ...
                ],
                // ...
            ],
        ],
    ],
];
```

--- 

<span id="yii2-file-crafter-using-previewStatus"></span>
    <h2 align="center">Preview status
    <small style="color: #009; font-size:9px">(optional)</small> 
</h2>

Key `previewStatus` contain status for preview file content on hover icon in the form.
  
Variants: `true`(default) or `false`  
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'previewStatus' => true,
                // ...
            ],
        ],
    ],
];
```

--- 

<span id="yii2-file-crafter-using-canDelete"></span>
    <h2 align="center">Can delete
    <small style="color: #009; font-size:9px">(optional)</small> 
</h2>

Key `canDelete` contain status for delete schema from the form.

Variants: `true`(default) or `false`
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'canDelete' => true,
                // ...
            ],
        ],
    ],
];
```

--- 

<span id="yii2-file-crafter-using-parseDataBase"></span>
<h2 align="center">
    Parse data base
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>

Key `parseDataBase` contain list of target for extend schema name list from database.

Variants: `array` with values: 
- `autocomplete`
- `fakeCache`

Default `empty`;
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'parseDataBase' => ['autocomplete','fakeCache'],
                // ...
            ],
        ],
    ],
];
```

<span id="yii2-file-crafter-using-Commands"></span>
<h2 align="center">
    Commands
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>

Key `commands` contain list `cli` command for call before generate any file.  
command make use of the `{{variable}}` in the command string ( see [Marks](#yii2-file-crafter-using-Marks) )

Example: generate gii model for table name from schema name before generate fileContent

Default `empty`;
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
            'fileCrafter' => [
            'options' => [
                // ... 
                'commands' => [
                    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models"  --interactive=0 --overwrite=1' // ... 
                ],
                // ...
            ],
        ],
    ],
];
```

<span id="yii2-file-crafter-using-Events"></span>
<h2 align="center">
    Events
    <small style="color: #009; font-size:9px">(optional)</small>
</h2>

Make use of the `eventHandlers` key to add a behavior to the module.

Example: add behavior `FileCrafterBehavior` to the module

Default `null`;
```php
$config['modules']['gii'] = [
    'class' => Module::class,
        'generators' => [
        'options' => [
                // ... 
                'eventHandlers' => FileCrafterBehavior::class,
                // ...
            ],
        ],
    ],
];
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

___

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
