<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

所有译文中的代码示例和界面标签均保留英文。

Yii2 File Crafter 是一个 Gii 生成器，用于从可重用模板和命名模式创建文件。

## 内容

- [设置](#yii2-file-crafter-setup)
- [配置和快速启动](#yii2-file-crafter-config)
- [迁移](#yii2-file-crafter-migrations)
- [选项和模板](#yii2-file-crafter-using)
- [模式编辑和生成](#yii2-file-crafter-schema)
- [测试](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## 设置

要求：PHP 8.0 或更高版本、Yii 2 应用程序和 `yiisoft/yii2-gii`。在应用程序中安装 File Crafter 和 Gii 作为开发依赖项：

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

对于本地 Composer 安装，请将 `composer` 替换为 `php composer.phar`。或者，将这些条目合并到应用程序的现有 `composer.json` 中：

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

然后运行：

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

应用程序中必须安装Gii：Composer不安装依赖包的`require-dev`依赖项。请参阅 [Composer 文档](https://getcomposer.org/doc/04-schema.md#require-dev) 和 [Gii 安装指南](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation)。

<span id="yii2-file-crafter-config"></span>

## 配置和快速启动

示例使用 `$config` 用于应用程序的配置数组。在一个 Basic 应用程序，在现有的应用程序中添加最小配置 `if (YII_ENV_DEV)` 阻止 `config/web.php`， 前 `return $config`。在一个 Advanced 应用程序，将相同的条目合并到所服务的应用程序的开发配置中 Gii， 例如 `backend/config/main-local.php`。保持 Gii 在 `bootstrap` 如果应用程序已启用它，则仅一次。

最低配置（无需迁移即可生成服务文件）：

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

在应用程序的基目录下创建`templates/file-crafter/service.tpl`：

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. 打开 `http://localhost/index.php?r=gii/fileCrafter`，调整应用程序的主机和入口脚本路径。
2. 进入 `Product Items` 在 **Schema name** 然后单击 **Create**。此模板的数据库属性可以留空。
3. 选择 `default` 模板组和保存的架构，然后单击 **Preview**。
4. 选中建议的`services/ProductItemsService.php`，保持选中状态，然后单击**Generate**。

生成的文件包含：

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` 指所选应用程序的基目录。 `@backend` 和 `@frontend` 等别名需要 Advanced 应用程序或显式别名配置；快速入门不依赖于它们。

以下替代配置显示了每个 File Crafter 选项。在选择其组之前创建引用的模板。 `commands` 和 `eventHandler` 选项解释如下。

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

## 迁移

除非 `migration` 是 `false`，否则将为每个选定的架构生成创建表迁移。将其应用于现有表会引发错误。现有表及其数据将被保留。对现有表的更改需要使用 Yii 的列和索引操作进行显式迁移。生成的迁移不会自动应用。

完整配置中显示的 `migration` 设置为默认设置：

- `root`：输出目录，通过 Yii 别名解析。
- `fileName`：后缀图案； `%s` 替换为架构的表名称。自动添加迁移时间戳前缀和 `.php` 扩展名。
- `template`：用​​于呈现迁移的 PHP 模板。

下面的所有选项示例都会修改上面的最低配置。要禁用迁移：

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## 选项和模板

### 使用模式

使用 **Create** 创建架构。选择编辑图标以更改或重命名已保存的架构，并在启用 `canDelete` 时使用删除按钮将其删除。架构名称转换为小写表名称：空格变为下划线，并且删除 ASCII 字母、数字、下划线和空格以外的字符。保存的模式是配置的缓存目录中的 JSON 文件；在移动应用程序或清除其运行时时保留这些文件。

该面板支持选择多个模式以及一次选择所有模式。空模式选择会导致生成器处理所有可用模式。预览显示建议的文件；生成写入选定的文件。缺少的源模板将被跳过，因此如果不存在预期的文件，请验证源路径。

### 数据库字段和导入

在架构编辑器中添加、删除和重新排序字段。每个字段都有名称、注释、类型、大小以及 `FK`、`UN` 和 `NN` 标志。 `UN` 表示唯一，`NN` 表示非空。 `FK` 标志本身并没有定义外键约束；引用的表和列必须存在于架构的外键元数据中。字段名称可以暗示类型和标志，应进行审查。

字段类型选择器提供 `string`、`int`、`boolean`、`text`、`timestamp`、`datetime`、`date`、`time`、`json`、 `float`、`double`、`decimal`、`jsonb`、`binary`、`money`、`smallint`、`bigint`、`char`、 `varchar`、`tinyint`、`enum` 和 `set`。数据库支持因类型和驱动程序而异。回归套件练习 SQLite 和 MySQL；它并没有为每个数据库上的每种类型建立支持。

`parseDataBase` 可以添加表名称以自动完成或使用 `fakeCache` 显示数据库派生模式。后者在不创建 JSON 缓存文件的情况下显示，并且无法通过面板删除。数据库自动完成需要启用 `autoCompleteStatus`。

### 应用和自定义迁移

生成的迁移必须通过应用程序的 Yii 迁移命令进行审查和应用。生成的`safeDown()`删除创建的表；在回滚迁移之前检查数据丢失的影响。自定义迁移模板可以使用 `{{migrationClass}}` 和 `{{tableName}}` 以及架构和生成器对象。导入的主键、外键和索引存储在模式元数据中；各个字段标志不提供引用的表或列。

命令结果包括输出和`resultCode`。报告非零命令退出代码，但其本身不会停止生成已配置的模板。

- [替换标记](#yii2-file-crafter-using-Marks)
- [缓存](#yii2-file-crafter-using-Cache)
- [来源](#yii2-file-crafter-using-Source)
- [模板](#yii2-file-crafter-using-Templates)
- [自定义字段](#yii2-file-crafter-using-CustomFields)
- [自动完成状态](#yii2-file-crafter-using-autoCompleteStatus)
- [自动完成列表](#yii2-file-crafter-using-autoCompleteList)
- [预览状态](#yii2-file-crafter-using-previewStatus)
- [可以删除](#yii2-file-crafter-using-canDelete)
- [解析数据库](#yii2-file-crafter-using-parseDataBase)
- [命令](#yii2-file-crafter-using-Commands)
- [事件](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## 替换标记

模板内容、路径和命令中的标记被替换。使用双大括号，其拼写如下所示。对于名为 `Product Items` 的架构：

|马克|结果 |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

大写和小写使用规范化的表名称，包括下划线。自定义字段使用相同的语法，例如 `{{singular}}`；参见 [自定义字段](#yii2-file-crafter-using-CustomFields)。未知标记保持不变，因此请在预览中检查文件名。

<span id="yii2-file-crafter-using-Cache"></span>

## 缓存

架构存储为 JSON 文件。默认缓存设置：

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## 来源

默认源设置（快速入门覆盖 `dir`）：

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## 模板

`templates` 将组名称映射到源模板路径和输出路径的数组：

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

预览前在 Gii 中选择所需的组。

- 相对源路径从`source['dir']`开始；以 Yii 别名开头的路径使用该别名。不带扩展名的源路径接收 `source['ext']`，默认为 `.tpl`。
- 相对输出路径从 `@app` 开始。明确指定所需的扩展名；普通模板输出路径不添加扩展名。
- 两个路径都可能包含 [替换标记](#yii2-file-crafter-using-Marks)。

常规 `.tpl` 文件被读取为文本，然后替换其标记。其中的 PHP 被复制到输出中，如快速入门中所示。 PHP模板用`yii\web\View::renderFile`渲染并接收`$schema`和`$generator`；渲染后进行标记替换。当前实现在源路径包含 `.php` 时选择 PHP 渲染，因此将文本模板保留在名称包含 `.php` 的目录之外。

例如，`templates/file-crafter/view.php` 可以包含：

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

对于 `Product Items`，输出为：

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## 自定义字段

键定义自定义标记；这些值定义模式编辑器中的标签：

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

对于架构 `Product Items`， 进入 `product` 在 **Singular name** 和 `products` 在 **Plural name**。文本模板可以使用这些值：

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

结果：

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## 自动完成状态

`autoCompleteStatus` 为 **Schema name** 启用内置、自定义和数据库建议。默认值：`false`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## 自动完成列表

`autoCompleteList` 提供自定义架构名称建议 `autoCompleteStatus` 是 `true`。默认值：空数组。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## 预览状态

`previewStatus` 启用图标悬停时显示的架构内容预览。默认值：`true`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## 可以删除

`canDelete` 控制面板中的模式删除。默认值：`true`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## 解析数据库

`parseDataBase` 将表名导入建议 (`autocomplete`) 和/或将数据库派生的模式导入面板 (`fakeCache`)。默认值：空数组。这些选项需要配置 `db` 应用程序组件。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## 命令

`commands` 是替换为 [替换标记](#yii2-file-crafter-using-Marks) 的 CLI 命令列表。默认值：空数组。在渲染其配置的模板之前，在使用选定文件的显式 **Generate** 提交上为每个选定模式运行命令。 **Preview** 从不执行它们。

对于配置了 Gii 控制台模块、现有表和 `common\models` 命名空间的应用程序，此命令生成其 ActiveRecord 模型：

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

命令在 PHP 进程的工作目录中运行。调整应用程序的 PHP 可执行文件、控制台入口脚本路径和命名空间。命令可以独立于 Gii 中选择的文件来修改文件。

<span id="yii2-file-crafter-using-Events"></span>

## 事件

`eventHandler` 将 Yii 行为附加到生成器。默认值：`null`。在应用程序中创建`components/behaviors/FileCrafterBehavior.php`：

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

以最低配置启用该行为：

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

在 Advanced 应用程序中，调整行为的命名空间和配置以匹配其位置，例如 `backend\components\behaviors`。需要 `events()` 映射：处理程序方法名称本身不订阅事件。

所有事件均暴露 `options`。生成前，事件包含`listSchemaDto`和已解析的`generateList`；处理程序可以更改选定的表名称。生成后，事件包含`files`（`yii\gii\CodeFile[]`）。渲染事件暴露 `schema`、`sourcePath`、`generatePath`、`replaceList` 和 `content`； `content` 在渲染后填充。

命令事件公开 `cmd`，它是 `andy87\yii2\file_crafter\components\models\dto\Cmd` 的实例：

- `exec`（`string`）：标记替换后的命令。
- `output`（`?string`）：执行前`null`，执行后命令输出。
- `replaceList` (`array`)：标记模式的替换映射。

<span id="yii2-file-crafter-schema"></span>

## 模式编辑和生成

架构编辑器接受 JSON 字符串数组形式的枚举/设置值，例如 `["draft", "published", "owner's"]`。保存架构之前会报告无效列表。旧版无效架构会在预览中报告，而不是导致异常。

Preview 从不运行配置的 CLI 命令。命令仅针对使用选定文件的显式生成提交运行。迁移文件名保留预览表单提交的时间戳，包括稍后发生生成时的时间戳。

数据库导入在缓存模式中保留主键和外键、引用操作、索引、小数位数、自动增量、无符号标志和列默认值。外键与表一起创建；引用的表必须已经存在。与所有生成的迁移一样，请在应用之前检查结果。

<span id="yii2-file-crafter-tests"></span>

## 测试

PHPUnit 开发依赖项需要 PHP 8.1 或更高版本以及 `dom`、`mbstring` 和 `pdo_sqlite` 扩展。从此存储库的克隆运行这些命令：

```sh
composer update --prefer-stable --prefer-dist
composer test
```

仅检查自述文件：

```sh
composer test:docs
```

文档测试直接从此文件读取示例。他们检查 PHP 语法、生成器配置、快速入门的预览/生成流程、模板渲染、标记、事件订阅、独特的部分锚点和内部链接。它们不执行记录的特定于应用程序的 CLI 命令或请求外部网站。

默认套件使用临时文件和内存 SQLite 数据库。要启用 MySQL 回归测试，请提供一次性测试数据库和 `pdo_mysql` 扩展：

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

MySQL 测试仅创建和删除它们自己的随机命名的表。它们检查导入的键、十进制值、默认值和约束强制执行。 Gii 控制器测试涵盖隔离的生成器突变、重复预览、跨分钟边界的迁移选择以及枚举/集合表单验证。 CI 在 PHP 8.1、8.2、8.4 和 8.5 以及 MySQL 8.4 上运行该套件，包括 README 检查，并单独检查 PHP 8.0 语法。

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
