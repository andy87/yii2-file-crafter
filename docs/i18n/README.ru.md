<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Примеры кода и названия элементов интерфейса во всех переводах сохранены на английском языке.

Yii2 File Crafter — это генератор Gii для создания файлов из повторно используемых шаблонов и именованных схем.

## Содержание

- [Настраивать](#yii2-file-crafter-setup)
- [Конфигурация и быстрый старт](#yii2-file-crafter-config)
- [Миграции](#yii2-file-crafter-migrations)
- [Опции и шаблоны](#yii2-file-crafter-using)
- [Редактирование и генерация схемы](#yii2-file-crafter-schema)
- [Тесты](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Установка

Требования: PHP 8.0 или новее, приложение Yii 2 и `yiisoft/yii2-gii`. Установите File Crafter и Gii в качестве зависимостей для разработки в приложении:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Для локальной установки Composer замените `composer` на `php composer.phar`. Альтернативно, объедините эти записи с существующим `composer.json` приложения:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Затем запустите:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii должен быть установлен в приложении: Composer не устанавливает зависимости `require-dev` пакетов зависимостей. См. [Документация Composer](https://getcomposer.org/doc/04-schema.md#require-dev) и [Установка Gii](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Конфигурация и быстрый старт

В примерах в качестве массива конфигурации приложения используется `$config`. В приложении Basic добавьте минимальную конфигурацию внутри существующего блока `if (YII_ENV_DEV)` в `config/web.php` перед `return $config`. В приложении Advanced объедините те же записи с конфигурацией разработки приложения, которое обслуживает Gii, например `backend/config/main-local.php`. Сохраняйте Gii в `bootstrap` только один раз, если приложение уже позволяет это сделать.

Минимальная конфигурация (генерирует файл сервиса без миграции):

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

Создайте `templates/file-crafter/service.tpl` в базовом каталоге приложения:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Откройте `http://localhost/index.php?r=gii/fileCrafter`, настроив хост и путь к сценарию входа для приложения.
2. Введите `Product Items` в **Schema name** и нажмите **Create**. Атрибуты базы данных для этого шаблона можно оставить пустыми.
3. Выберите группу шаблонов `default` и сохраненную схему, затем нажмите **Preview**.
4. Отметьте предложенный `services/ProductItemsService.php`, оставьте его выбранным и нажмите **Generate**.

Результирующий файл содержит:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` относится к базовому каталогу выбранного приложения. Такие псевдонимы, как `@backend` и `@frontend`, требуют приложения Advanced или явной настройки псевдонима; Быстрый старт от них не зависит.

В следующей альтернативной конфигурации показаны все опции File Crafter. Создайте указанные шаблоны, прежде чем выбирать их группу. Опции `commands` и `eventHandler` описаны ниже.

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

## Миграции

Если `migration` не равен `false`, миграция создания таблицы создается для каждой выбранной схемы. Применение его к существующей таблице вызывает ошибку. Существующая таблица и ее данные сохраняются. Изменения в существующих таблицах требуют явной миграции с использованием операций со столбцами и индексами Yii. Созданные миграции не применяются автоматически.

Настройки `migration`, показанные в полной конфигурации, являются значениями по умолчанию:

- `root`: выходной каталог, разрешенный через псевдонимы Yii.
- `fileName`: шаблон суффикса; `%s` заменяется именем таблицы схемы. Префикс временной метки миграции и расширение `.php` добавляются автоматически.
- `template`: шаблон PHP, используемый для визуализации миграции.

Все приведенные ниже примеры опций изменяют приведенную выше минимальную конфигурацию. Чтобы отключить миграцию:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Опции и шаблоны

### Работа со схемами

Создайте схему с помощью **Create**. Выберите значок редактирования, чтобы изменить или переименовать сохраненную схему, и используйте кнопку удаления, чтобы удалить ее, когда `canDelete` включен. Имя схемы преобразуется в имя таблицы в нижнем регистре: пробелы становятся символами подчеркивания, а символы, отличные от букв ASCII, цифр, подчеркиваний и пробелов, удаляются. Сохраненные схемы представляют собой файлы JSON в настроенном каталоге кэша; сохраните эти файлы при перемещении приложения или очистке среды его выполнения.

Панель поддерживает выбор нескольких схем и выбор всех одновременно. Выбор пустой схемы приводит к тому, что генератор обрабатывает все доступные схемы. Предварительный просмотр показывает предлагаемые файлы; Generate записывает выбранные файлы. Отсутствующий исходный шаблон пропускается, поэтому проверьте исходный путь, если ожидаемый файл отсутствует.

### Поля базы данных и импорт

Добавляйте, удаляйте и меняйте порядок полей в редакторе схемы. Каждое поле имеет имя, комментарий, тип, размер и флаги `FK`, `UN` и `NN`. `UN` означает уникальный, а `NN` означает не ноль. Флаг `FK` сам по себе не определяет ограничение внешнего ключа; таблица и столбцы, на которые ссылаются, должны присутствовать в метаданных внешнего ключа схемы. Названия полей могут указывать на тип и флаги, которые следует просмотреть.

Селектор типа поля предлагает `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` и `set`. Поддержка базы данных зависит от типа и драйвера. Пакет регрессии проверяет SQLite и MySQL; он не обеспечивает поддержку каждого типа в каждой базе данных.

`parseDataBase` может добавлять имена таблиц для автозаполнения или отображать схемы, полученные из базы данных, с помощью `fakeCache`. Последние отображаются без создания файлов кэша JSON и не могут быть удалены через панель. Для автозаполнения базы данных необходимо включить `autoCompleteStatus`.

### Применение и настройка миграций

Созданные миграции необходимо просмотреть и применить с помощью команд миграции Yii приложения. Сгенерированный `safeDown()` удаляет созданную таблицу; Прежде чем откатывать миграцию, оцените влияние потери данных. Пользовательский шаблон миграции может использовать `{{migrationClass}}` и `{{tableName}}` вместе со схемой и объектами генератора. Импортированные первичные ключи, внешние ключи и индексы хранятся в метаданных схемы; отдельные флаги полей не предоставляют ссылку на таблицу или столбцы.

Результат команды включает выходные данные и `resultCode`. Сообщается о ненулевом коде завершения команды, но он сам по себе не останавливает создание настроенных шаблонов.

- [Метки](#yii2-file-crafter-using-Marks)
- [Кэш](#yii2-file-crafter-using-Cache)
- [Источник](#yii2-file-crafter-using-Source)
- [Шаблоны](#yii2-file-crafter-using-Templates)
- [Пользовательские поля](#yii2-file-crafter-using-CustomFields)
- [Статус автозаполнения](#yii2-file-crafter-using-autoCompleteStatus)
- [Список автозаполнения](#yii2-file-crafter-using-autoCompleteList)
- [Статус предварительного просмотра](#yii2-file-crafter-using-previewStatus)
- [Удаление схем](#yii2-file-crafter-using-canDelete)
- [Импорт из базы данных](#yii2-file-crafter-using-parseDataBase)
- [Команды](#yii2-file-crafter-using-Commands)
- [События](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Метки

Метки заменяются в содержимом шаблона, путях и командах. Используйте двойные скобки с точным написанием, указанным ниже. Для схемы с именем `Product Items`:

| Марк | Результат |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

В верхнем и нижнем регистре используется нормализованное имя таблицы, включая символы подчеркивания. Настраиваемые поля используют тот же синтаксис, например `{{singular}}`; см. [Пользовательские поля](#yii2-file-crafter-using-CustomFields). Неизвестные пометки остаются без изменений, поэтому проверяйте имена файлов в режиме предварительного просмотра.

<span id="yii2-file-crafter-using-Cache"></span>

## Кэш

Схемы хранятся в виде файлов JSON. Настройки кэша по умолчанию:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Источник

Настройки источника по умолчанию (быстрый запуск имеет приоритет над `dir`):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Шаблоны

`templates` сопоставляет имена групп с массивами путей исходного шаблона и выходных путей:

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

Перед просмотром выберите нужную группу в Gii.

- Относительные исходные пути начинаются с `source['dir']`; пути, начинающиеся с псевдонима Yii, используют этот псевдоним. Исходный путь без расширения получает `source['ext']`, который по умолчанию равен `.tpl`.
- Относительные выходные пути начинаются с `@app`. Явно укажите желаемое расширение; никакое расширение не добавляется к обычным путям вывода шаблонов.
- Оба пути могут содержать [Метки](#yii2-file-crafter-using-Marks).

Обычный файл `.tpl` читается как текст, а затем его метки заменяются. PHP внутри него копируется в вывод, как в Быстром старте. Шаблоны PHP визуализируются с помощью `yii\web\View::renderFile` и получают `$schema` и `$generator`; Замена метки следует за рендерингом. Текущая реализация выбирает рендеринг PHP, когда исходный путь содержит `.php`, поэтому храните текстовые шаблоны вне каталогов, имена которых содержат `.php`.

Например, `templates/file-crafter/view.php` может содержать:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

Для `Product Items` выходные данные:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Пользовательские поля

Клавиши определяют пользовательские метки; значения определяют метки в редакторе схемы:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Для схемы `Product Items` введите `product` в **Singular name** и `products` в **Plural name**. Текстовый шаблон может использовать следующие значения:

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Результат:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Статус автозаполнения

`autoCompleteStatus` включает встроенные, пользовательские предложения и предложения базы данных для **Schema name**. По умолчанию: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Список автозаполнения

`autoCompleteList` предоставляет специальные варианты имени схемы, если `autoCompleteStatus` — `true`. По умолчанию: пустой массив.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Статус предварительного просмотра

`previewStatus` включает предварительный просмотр содержимого схемы, отображаемый при наведении на значок. По умолчанию: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Удаление схем

`canDelete` управляет удалением схемы из панели. По умолчанию: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Импорт из базы данных

`parseDataBase` импортирует имена таблиц в предложения (`autocomplete`) и/или схемы, производные от базы данных, на панель (`fakeCache`). По умолчанию: пустой массив. Для этих опций требуется настроенный компонент приложения `db`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Команды

`commands` — это список команд CLI с заменой [Метки](#yii2-file-crafter-using-Marks). По умолчанию: пустой массив. Команды выполняются для каждой выбранной схемы при явной отправке **Generate** с выбранными файлами перед отрисовкой настроенных шаблонов. **Preview** никогда их не выполняет.

Для приложения с настроенным консольным модулем Gii, существующей таблицей и пространством имен `common\models` эта команда генерирует модель ActiveRecord:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Команды выполняются в рабочем каталоге процесса PHP. Настройте исполняемый файл PHP, путь к сценарию ввода консоли и пространство имен для приложения. Команды могут изменять файлы независимо от файлов, выбранных в Gii.

<span id="yii2-file-crafter-using-Events"></span>

## События

`eventHandler` придает генератору поведение Yii. По умолчанию: `null`. Создайте `components/behaviors/FileCrafterBehavior.php` в приложении:

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

Включите поведение в минимальной конфигурации:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

В приложении Advanced настройте пространство имен и конфигурацию поведения в соответствии с его местоположением, например `backend\components\behaviors`. Требуется карта `events()`: сами по себе имена методов обработчиков не подписываются на события.

Все события предоставляют `options`. Перед генерацией событие содержит `listSchemaDto` и заполненный `generateList`; обработчики могут изменить имена выбранных таблиц. После генерации событие содержит `files` (`yii\gii\CodeFile[]`). События рендеринга предоставляют `schema`, `sourcePath`, `generatePath`, `replaceList` и `content`; `content` заполняется после рендеринга.

События команд предоставляют `cmd`, экземпляр `andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): команда после замены метки.
- `output` (`?string`): `null` перед выполнением, вывод команды после.
- `replaceList` (`array`): пометить карту замены для схемы.

<span id="yii2-file-crafter-schema"></span>

## Редактирование и генерация схемы

Редактор схемы принимает значения перечисления/установки в виде массива строк JSON, например `["draft", "published", "owner's"]`. О недопустимых списках сообщается перед сохранением схемы. О устаревших недопустимых схемах сообщается в предварительной версии, а не вызывается исключение.

Предварительная версия никогда не запускает настроенные команды CLI. Команды выполняются только для явного создания отправки с выбранными файлами. Имена файлов миграции сохраняют метку времени, отправленную формой предварительного просмотра, в том числе, когда создание происходит позже.

При импорте базы данных сохраняются первичные и внешние ключи, ссылочные действия, индексы, десятичная шкала, автоинкремент, беззнаковые флаги и значения столбцов по умолчанию в кэшированной схеме. Внешние ключи создаются вместе с таблицей; таблицы, на которые имеются ссылки, уже должны существовать. Как и в случае со всеми созданными миграциями, просмотрите результат перед его применением.

<span id="yii2-file-crafter-tests"></span>

## Тесты

Для зависимостей для разработки PHPUnit требуется PHP 8.1 или новее, а также расширения `dom`, `mbstring` и `pdo_sqlite`. Запустите эти команды из клона этого репозитория:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

Чтобы проверить только README:

```sh
composer test:docs
```

Тесты документации читают примеры прямо из этого файла. Они проверяют синтаксис PHP, конфигурацию генератора, процесс предварительного просмотра/создания быстрого запуска, рендеринг шаблонов, отметки, подписки на события, уникальные привязки разделов и внутренние ссылки. Они не выполняют документированные команды CLI для конкретного приложения и не запрашивают внешние веб-сайты.

Пакет по умолчанию использует временные файлы и базу данных SQLite в памяти. Чтобы включить регрессионный тест MySQL, предоставьте одноразовую тестовую базу данных и расширение `pdo_mysql`:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

Тесты MySQL создают и удаляют только свои собственные таблицы со случайными именами. Они проверяют импортированные ключи, десятичные значения, значения по умолчанию и соблюдение ограничений. Тесты контроллера Gii охватывают изолированные мутации генератора, повторный предварительный просмотр, выбор миграции через минутный интервал и проверку формы перечисления/установки. CI запускает пакет, включая проверки README, на PHP 8.1, 8.2, 8.4 и 8.5 с MySQL 8.4 и отдельно проверяет синтаксис PHP 8.0.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
