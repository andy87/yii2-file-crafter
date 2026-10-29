<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](README.md) | [Русский](docs/i18n/README.ru.md) | [简体中文](docs/i18n/README.zh-CN.md) | [Português (Brasil)](docs/i18n/README.pt-BR.md) | [Español](docs/i18n/README.es.md) | [日本語](docs/i18n/README.ja.md) | [Қазақша](docs/i18n/README.kk.md) | [Français](docs/i18n/README.fr.md) | [Deutsch](docs/i18n/README.de.md)

Code examples and interface labels remain in English in all translations.

Yii2 File Crafter is a Gii generator for creating files from reusable templates and named schemas.

## Contents

- [Setup](#yii2-file-crafter-setup)
- [Config and Quick Start](#yii2-file-crafter-config)
- [Migrations](#yii2-file-crafter-migrations)
- [Options and templates](#yii2-file-crafter-using)
- [Schema editing and generation](#yii2-file-crafter-schema)
- [Tests](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Setup

Requirements: PHP 8.0 or newer, a Yii 2 application, and `yiisoft/yii2-gii`.
Install File Crafter and Gii as development dependencies in the application:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

For a local Composer installation, replace `composer` with `php composer.phar`.
Alternatively, merge these entries into the application's existing `composer.json`:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Then run:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii must be installed in the application: Composer does not install the
`require-dev` dependencies of dependency packages. See the
[Composer documentation](https://getcomposer.org/doc/04-schema.md#require-dev) and
[Gii installation guide](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Config and Quick Start

The examples use `$config` for the application's configuration array. In a Basic
application, add the minimum configuration inside the existing `if (YII_ENV_DEV)`
block in `config/web.php`, before `return $config`. In an Advanced application,
merge the same entries into the development configuration of the application
that serves Gii, for example `backend/config/main-local.php`.
Keep Gii in `bootstrap` only once if the application already enables it.

Minimum configuration (generates a service file without a migration):

<!-- example: minimal-config -->
```php
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => yii\gii\Module::class,
    'generators' => [
        'fileCrafter' => [
            'class' => andy87\yii2\file_crafter\Crafter::class,
            'options' => [
                'source' => ['dir' => '@app/templates/file-crafter', 'ext' => '.tpl'],
                'migration' => false,
                'templates' => [
                    'default' => [
                        'service' => '@app/services/{{PascalCase}}Service.php',
                    ],
                ],
            ],
        ],
    ],
];
```

Create `templates/file-crafter/service.tpl` under the application's base directory:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Open `http://localhost/index.php?r=gii/fileCrafter`, adjusting the host and entry-script path for the application.
2. Enter `Product Items` in **Schema name** and click **Create**. Database attributes can be left empty for this template.
3. Select the `default` template group and the saved schema, then click **Preview**.
4. Check the proposed `services/ProductItemsService.php`, keep it selected, and click **Generate**.

The resulting file contains:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` refers to the selected application's base directory. Aliases such as
`@backend` and `@frontend` require an Advanced application or explicit alias
configuration; the Quick Start does not depend on them.

The following alternative configuration shows every File Crafter option. Create
the referenced templates before selecting their group. The `commands` and
`eventHandler` options are explained below.

<!-- example: full-config -->
```php
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => yii\gii\Module::class,
    'generators' => [
        'fileCrafter' => [
            'class' => andy87\yii2\file_crafter\Crafter::class,
            'options' => [
                'cache' => ['dir' => '@app/runtime/yii2-file-crafter/cache', 'ext' => '.json'],
                'source' => ['dir' => '@app/templates/file-crafter', 'ext' => '.tpl'],
                'custom_fields' => ['singular' => 'Singular name', 'plural' => 'Plural name'],
                'commands' => [],
                'eventHandler' => null,
                'autoCompleteStatus' => true,
                'autoCompleteList' => ['Product Items', 'Category Group'],
                'previewStatus' => true,
                'canDelete' => true,
                'parseDataBase' => ['autocomplete', 'fakeCache'],
                'migration' => [
                    'root' => '@app/migrations',
                    'fileName' => '_file_crafter_migration_%s',
                    'template' => '@vendor/andy87/yii2-file-crafter/src/components/templates/migration.php',
                ],
                'templates' => [
                    'default' => ['service' => '@app/services/{{PascalCase}}Service.php'],
                    'views' => ['view.php' => '@app/views/{{snake_case}}/index.php'],
                    'all' => [
                        'service' => '@app/services/{{PascalCase}}Service.php',
                        'view.php' => '@app/views/{{snake_case}}/index.php',
                    ],
                ],
            ],
        ],
    ],
];
```

<span id="yii2-file-crafter-migrations"></span>

## Migrations

Unless `migration` is `false`, a create-table migration is generated for each
selected schema. Applying it to an existing table raises an error. The existing
table and its data are preserved. Changes to existing tables require an explicit migration
using Yii's column and index operations. Generated migrations are not applied
automatically.

The `migration` settings shown in the full configuration are the defaults:

- `root`: output directory, resolved through Yii aliases.
- `fileName`: suffix pattern; `%s` is replaced with the schema's table name. A migration timestamp prefix and `.php` extension are added automatically.
- `template`: PHP template used to render the migration.

All option examples below modify the minimum configuration above. To disable migrations:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Options and templates

### Working with schemas

Create a schema with **Create**. Select the edit icon to change or rename a
saved schema, and use the delete button to remove it when `canDelete` is enabled.
The schema name is converted to a lowercase table name: spaces become
underscores and characters other than ASCII letters, digits, underscores and
whitespace are removed. Saved schemas are JSON files in the configured cache
directory; retain those files when moving the application or clearing its runtime.

The panel supports selecting multiple schemas and selecting all at once. An
empty schema selection causes the generator to process all available schemas.
Preview shows the proposed files; Generate writes the selected files. A missing
source template is skipped, so verify the source path if an expected file is absent.

### Database fields and imports

Add, remove and reorder fields in the schema editor. Each field has a name,
comment, type, size and `FK`, `UN` and `NN` flags. `UN` means unique and `NN`
means not null. The `FK` flag alone does not define a foreign-key constraint;
the referenced table and columns must be present in the schema's foreign-key
metadata. Field names can suggest a type and flags, which should be reviewed.

The field type selector offers `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`,
`date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`,
`char`, `varchar`, `tinyint`, `enum` and `set`. Database support varies by type and driver.
The regression suite exercises SQLite and MySQL; it does not establish support
for every type on every database.

`parseDataBase` can add table names to autocomplete or show database-derived
schemas with `fakeCache`. The latter are displayed without creating JSON cache
files and cannot be deleted through the panel. Database autocomplete requires
`autoCompleteStatus` to be enabled.

### Applying and customising migrations

Generated migrations must be reviewed and applied through the application's Yii
migration commands. The generated `safeDown()` drops the created table; review
the data-loss impact before rolling a migration back. A custom migration template
can use `{{migrationClass}}` and `{{tableName}}` along with the schema and generator
objects. Imported primary keys, foreign keys and indexes are stored in schema
metadata; individual field flags do not supply a referenced table or columns.

The command result includes output and `resultCode`. A non-zero command exit code
is reported but does not by itself stop generation of configured templates.

- [Marks](#yii2-file-crafter-using-Marks)
- [Cache](#yii2-file-crafter-using-Cache)
- [Source](#yii2-file-crafter-using-Source)
- [Templates](#yii2-file-crafter-using-Templates)
- [Custom fields](#yii2-file-crafter-using-CustomFields)
- [Autocomplete status](#yii2-file-crafter-using-autoCompleteStatus)
- [Autocomplete list](#yii2-file-crafter-using-autoCompleteList)
- [Preview status](#yii2-file-crafter-using-previewStatus)
- [Can delete](#yii2-file-crafter-using-canDelete)
- [Parse database](#yii2-file-crafter-using-parseDataBase)
- [Commands](#yii2-file-crafter-using-Commands)
- [Events](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Marks

Marks are replaced in template contents, paths and commands. Use double braces
with the exact spelling shown below. For a schema named `Product Items`:

| Mark | Result |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Uppercase and lowercase use the normalized table name, including underscores.
Custom fields use the same syntax, for example `{{singular}}`; see
[Custom fields](#yii2-file-crafter-using-CustomFields).
Unknown marks are left unchanged, so check filenames in Preview.

<span id="yii2-file-crafter-using-Cache"></span>

## Cache

Schemas are stored as JSON files. Default cache settings:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Source

Default source settings (the Quick Start overrides `dir`):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Templates

`templates` maps group names to arrays of source-template paths and output paths:

<!-- example: template-groups -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['templates'] = [
    'group1' => [
        'service' => '@app/services/{{PascalCase}}Service.php',
    ],
    'group2' => [
        'view.php' => '@app/views/{{snake_case}}/index.php',
        '@app/templates/file-crafter/service.tpl' => 'services/{{PascalCase}}Service.php',
    ],
];
```

Select the required group in Gii before Preview.

- Relative source paths start at `source['dir']`; paths beginning with a Yii alias use that alias. A source path without an extension receives `source['ext']`, which defaults to `.tpl`.
- Relative output paths start at `@app`. Specify the desired extension explicitly; no extension is added to ordinary template output paths.
- Both paths may contain [marks](#yii2-file-crafter-using-Marks).

A regular `.tpl` file is read as text and then its marks are replaced. PHP inside
it is copied into the output, as in the Quick Start. PHP templates are rendered
with `yii\web\View::renderFile` and receive `$schema` and `$generator`; mark
replacement follows rendering. The current implementation selects PHP rendering
when the source path contains `.php`, so keep text templates outside directories
whose names contain `.php`.

For example, `templates/file-crafter/view.php` can contain:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

For `Product Items`, the output is:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Custom fields

The keys define custom marks; the values define labels in the schema editor:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

For schema `Product Items`, enter `product` in **Singular name** and `products`
in **Plural name**. A text template can use these values:

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Result:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Autocomplete status

`autoCompleteStatus` enables built-in, custom and database suggestions for **Schema name**. Default: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Autocomplete list

`autoCompleteList` supplies custom schema-name suggestions when `autoCompleteStatus` is `true`. Default: an empty array.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Preview status

`previewStatus` enables the schema-content preview shown on icon hover. Default: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Can delete

`canDelete` controls schema deletion from the panel. Default: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Parse database

`parseDataBase` imports table names into suggestions (`autocomplete`) and/or
database-derived schemas into the panel (`fakeCache`). Default: an empty array.
These options require a configured `db` application component.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Commands

`commands` is a list of CLI commands with [mark](#yii2-file-crafter-using-Marks)
replacement. Default: an empty array. Commands run for each selected schema on
an explicit **Generate** submission with selected files, before rendering its
configured templates. **Preview** never executes them.

For an application with the Gii console module configured, an existing table
and a `common\models` namespace, this command generates its ActiveRecord model:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Commands run in the PHP process's working directory. Adjust the PHP executable,
console entry-script path and namespace for the application. Commands can modify
files independently of the files selected in Gii.

<span id="yii2-file-crafter-using-Events"></span>

## Events

`eventHandler` attaches a Yii behavior to the generator. Default: `null`.
Create `components/behaviors/FileCrafterBehavior.php` in the application:

<!-- example: event-behavior -->
```php
<?php

namespace app\components\behaviors;

use Yii;
use yii\base\Behavior;
use andy87\yii2\file_crafter\components\events\{CrafterEvent, CrafterEventCommand, CrafterEventGenerate, CrafterEventRender};

/** Records generator events without changing generated files or commands. */
class FileCrafterBehavior extends Behavior
{
    /** @return array Event names mapped to their handlers. */
    public function events(): array
    {
        return [
            CrafterEvent::BEFORE_INIT => 'onInit',
            CrafterEvent::AFTER_INIT => 'onInit',
            CrafterEventGenerate::BEFORE => 'onGenerate',
            CrafterEventGenerate::AFTER => 'onGenerate',
            CrafterEventCommand::BEFORE => 'onCommand',
            CrafterEventCommand::AFTER => 'onCommand',
            CrafterEventRender::BEFORE => 'onRender',
            CrafterEventRender::AFTER => 'onRender',
        ];
    }

    /**
     * Record generator initialization.
     * @param CrafterEvent $event Initialization event with the active options.
     * @return void
     */
    public function onInit(CrafterEvent $event): void
    {
        Yii::info($event->name, __METHOD__);
    }

    /**
     * Record the input schemas before generation and the output files afterwards.
     * @param CrafterEventGenerate $event Generation event and its current payload.
     * @return void
     */
    public function onGenerate(CrafterEventGenerate $event): void
    {
        Yii::info([$event->name, $event->listSchemaDto, $event->files], __METHOD__);
    }

    /**
     * Record the command before execution and its output afterwards.
     * @param CrafterEventCommand $event Command event containing a Cmd object.
     * @return void
     */
    public function onCommand(CrafterEventCommand $event): void
    {
        Yii::info([$event->name, $event->cmd->exec, $event->cmd->output, $event->cmd->replaceList], __METHOD__);
    }

    /**
     * Record template paths before rendering and the generated content afterwards.
     * @param CrafterEventRender $event Render event for one schema and template.
     * @return void
     */
    public function onRender(CrafterEventRender $event): void
    {
        Yii::info([$event->name, $event->schema, $event->sourcePath, $event->generatePath, $event->replaceList, $event->content], __METHOD__);
    }
}
```

Enable the behavior in the minimum configuration:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

In an Advanced application, adjust the behavior's namespace and configuration
to match its location, for example `backend\components\behaviors`.
The `events()` map is required: handler method names alone do not subscribe to events.

All events expose `options`. Before generation, the event contains `listSchemaDto`
and the resolved `generateList`; handlers can change the selected table names.
After generation, the event contains `files` (`yii\gii\CodeFile[]`).
Render events expose `schema`, `sourcePath`, `generatePath`, `replaceList` and
`content`; `content` is populated after rendering.

Command events expose `cmd`, an instance of
`andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): command after mark replacement.
- `output` (`?string`): `null` before execution, command output afterwards.
- `replaceList` (`array`): mark replacement map for the schema.

<span id="yii2-file-crafter-schema"></span>

## Schema editing and generation

The schema editor accepts enum/set values as a JSON array of strings, for example
`["draft", "published", "owner's"]`. Invalid lists are reported before saving the
schema. Legacy invalid schemas are reported in Preview instead of causing an exception.

Preview never runs configured CLI commands. Commands run only for an explicit
Generate submission with selected files. Migration filenames retain the timestamp
submitted by the preview form, including when Generate happens in a later minute.

Database imports retain primary and foreign keys, referential actions, indexes,
decimal scale, auto-increment, unsigned flags and column defaults in the cached
schema. Foreign keys are created with the table; referenced tables must already
exist. As with all generated migrations, review the result before applying it.

<span id="yii2-file-crafter-tests"></span>

## Tests

The PHPUnit development dependencies require PHP 8.1 or newer and the `dom`, `mbstring` and `pdo_sqlite` extensions.
Run these commands from a clone of this repository:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

To check only the README:

```sh
composer test:docs
```

The documentation tests read examples directly from this file. They check PHP
syntax, generator configuration, the Quick Start's Preview/Generate flow,
template rendering, marks, event subscriptions, unique section anchors and
internal links. They do not execute the documented application-specific CLI
commands or request external websites.

The default suite uses temporary files and an in-memory SQLite database. To enable the MySQL regression test, provide a disposable test database and the `pdo_mysql` extension:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

The MySQL tests create and remove only their own randomly named tables. They check
imported keys, decimal values, defaults and constraint enforcement. Gii controller
tests cover isolated generator mutations, repeated Preview, migration selection
across a minute boundary, and enum/set form validation. CI runs the suite, including
the README checks, on PHP 8.1, 8.2, 8.4 and 8.5 with MySQL 8.4, and checks PHP 8.0
syntax separately.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
