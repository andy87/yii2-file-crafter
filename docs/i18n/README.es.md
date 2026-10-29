<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Los ejemplos de código y las etiquetas de la interfaz se mantienen en inglés en todas las traducciones.

Yii2 File Crafter es un generador Gii para crear archivos a partir de plantillas reutilizables y esquemas con nombre.

## Contenido

- [Configuración](#yii2-file-crafter-setup)
- [Configuración e inicio rápido](#yii2-file-crafter-config)
- [Migraciones](#yii2-file-crafter-migrations)
- [Opciones y plantillas](#yii2-file-crafter-using)
- [Edición y generación de esquemas.](#yii2-file-crafter-schema)
- [Pruebas](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Configuración

Requisitos: PHP 8.0 o posterior, una aplicación Yii 2 y `yiisoft/yii2-gii`. Instale File Crafter y Gii como dependencias de desarrollo en la aplicación:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Para una instalación local de Composer, reemplace `composer` con `php composer.phar`. Alternativamente, combine estas entradas con el `composer.json` existente de la aplicación:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Luego ejecuta:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii debe estar instalado en la aplicación: Composer no instala las dependencias `require-dev` de los paquetes de dependencia. Consulte [Documentación de Composer](https://getcomposer.org/doc/04-schema.md#require-dev) y [Guía de instalación de Gii](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Configuración e inicio rápido

Los ejemplos utilizan `$config` para la matriz de configuración de la aplicación. En una aplicación Basic, agregue la configuración mínima dentro del bloque `if (YII_ENV_DEV)` existente en `config/web.php`, antes de `return $config`. En una aplicación Advanced, combine las mismas entradas en la configuración de desarrollo de la aplicación que sirve a Gii, por ejemplo, `backend/config/main-local.php`. Mantenga Gii en `bootstrap` solo una vez si la aplicación ya lo habilita.

Configuración mínima (genera un archivo de servicio sin migración):

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

Cree `templates/file-crafter/service.tpl` en el directorio base de la aplicación:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Abra `http://localhost/index.php?r=gii/fileCrafter` y ajuste la ruta del host y del script de entrada para la aplicación.
2. Ingrese `Product Items` en **Schema name** y haga clic en **Create**. Los atributos de la base de datos se pueden dejar vacíos para esta plantilla.
3. Seleccione el grupo de plantillas `default` y el esquema guardado, luego haga clic en **Preview**.
4. Marque el `services/ProductItemsService.php` propuesto, manténgalo seleccionado y haga clic en **Generate**.

El archivo resultante contiene:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` hace referencia al directorio base de la aplicación seleccionada. Alias ​​como `@backend` y `@frontend` requieren una aplicación Advanced o una configuración de alias explícita; el Inicio Rápido no depende de ellos.

La siguiente configuración alternativa muestra todas las opciones de File Crafter. Cree las plantillas referenciadas antes de seleccionar su grupo. Las opciones `commands` y `eventHandler` se explican a continuación.

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

## Migraciones

A menos que `migration` sea `false`, se genera una migración de creación de tabla para cada esquema seleccionado. Aplicarlo a una tabla existente genera un error. Se conservan la tabla existente y sus datos. Los cambios en las tablas existentes requieren una migración explícita utilizando las operaciones de índice y columna de Yii. Las migraciones generadas no se aplican automáticamente.

Las configuraciones `migration` que se muestran en la configuración completa son las predeterminadas:

- `root`: directorio de salida, resuelto mediante alias Yii.
- `fileName`: patrón de sufijo; `%s` se reemplaza con el nombre de la tabla del esquema. Se agregan automáticamente un prefijo de marca de tiempo de migración y una extensión `.php`.
- `template`: Plantilla PHP utilizada para renderizar la migración.

Todos los ejemplos de opciones a continuación modifican la configuración mínima anterior. Para deshabilitar las migraciones:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Opciones y plantillas

### Trabajar con esquemas

Cree un esquema con **Create**. Seleccione el ícono de edición para cambiar o cambiar el nombre de un esquema guardado y use el botón Eliminar para eliminarlo cuando `canDelete` esté habilitado. El nombre del esquema se convierte en un nombre de tabla en minúsculas: los espacios se convierten en guiones bajos y se eliminan los caracteres que no sean letras ASCII, dígitos, guiones bajos y espacios en blanco. Los esquemas guardados son archivos JSON en el directorio de caché configurado; conserve esos archivos al mover la aplicación o borrar su tiempo de ejecución.

El panel admite la selección de múltiples esquemas y la selección de todos a la vez. Una selección de esquema vacía hace que el generador procese todos los esquemas disponibles. La vista previa muestra los archivos propuestos; Generar escribe los archivos seleccionados. Se omite una plantilla de origen que falta, por lo tanto, verifique la ruta de origen si falta un archivo esperado.

### Importaciones y campos de base de datos

Agregue, elimine y reordene campos en el editor de esquemas. Cada campo tiene un nombre, comentario, tipo, tamaño y banderas `FK`, `UN` y `NN`. `UN` significa único y `NN` significa no nulo. El indicador `FK` por sí solo no define una restricción de clave externa; la tabla y las columnas a las que se hace referencia deben estar presentes en los metadatos de clave externa del esquema. Los nombres de los campos pueden sugerir un tipo y banderas, que deben revisarse.

El selector de tipo de campo ofrece `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` y `set`. El soporte de la base de datos varía según el tipo y el controlador. La suite de regresión ejercita SQLite y MySQL; no establece soporte para todos los tipos en todas las bases de datos.

`parseDataBase` puede agregar nombres de tablas para autocompletar o mostrar esquemas derivados de bases de datos con `fakeCache`. Estos últimos se muestran sin crear archivos de caché JSON y no se pueden eliminar a través del panel. La función de autocompletar de la base de datos requiere que `autoCompleteStatus` esté habilitado.

### Aplicar y personalizar migraciones

Las migraciones generadas deben revisarse y aplicarse a través de los comandos de migración de Yii de la aplicación. El `safeDown()` generado descarta la tabla creada; revise el impacto de la pérdida de datos antes de revertir una migración. Una plantilla de migración personalizada puede usar `{{migrationClass}}` y `{{tableName}}` junto con el esquema y los objetos generadores. Las claves primarias, claves externas e índices importados se almacenan en metadatos del esquema; Los indicadores de campo individuales no proporcionan una tabla o columnas referenciadas.

El resultado del comando incluye salida y `resultCode`. Se informa un código de salida de comando distinto de cero, pero por sí solo no detiene la generación de plantillas configuradas.

- [Marcadores](#yii2-file-crafter-using-Marks)
- [Cache](#yii2-file-crafter-using-Cache)
- [Fuente](#yii2-file-crafter-using-Source)
- [Plantillas](#yii2-file-crafter-using-Templates)
- [Campos personalizados](#yii2-file-crafter-using-CustomFields)
- [Estado de autocompletar](#yii2-file-crafter-using-autoCompleteStatus)
- [Lista de autocompletar](#yii2-file-crafter-using-autoCompleteList)
- [Estado de vista previa](#yii2-file-crafter-using-previewStatus)
- [Eliminación de esquemas](#yii2-file-crafter-using-canDelete)
- [Analizar base de datos](#yii2-file-crafter-using-parseDataBase)
- [Comandos](#yii2-file-crafter-using-Commands)
- [Eventos](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Marcadores

Las marcas se reemplazan en el contenido, las rutas y los comandos de la plantilla. Utilice llaves dobles con la ortografía exacta que se muestra a continuación. Para un esquema denominado `Product Items`:

| marca | Resultado |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Las mayúsculas y minúsculas utilizan el nombre de la tabla normalizada, incluidos los guiones bajos. Los campos personalizados utilizan la misma sintaxis, por ejemplo `{{singular}}`; ver [Campos personalizados](#yii2-file-crafter-using-CustomFields). Las marcas desconocidas no se modifican, así que verifique los nombres de los archivos en Vista previa.

<span id="yii2-file-crafter-using-Cache"></span>

## Cache

Los esquemas se almacenan como archivos JSON. Configuración de caché predeterminada:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Fuente

Configuración de fuente predeterminada (el inicio rápido anula `dir`):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Plantillas

`templates` asigna nombres de grupos a matrices de rutas de plantilla de origen y rutas de salida:

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

Seleccione el grupo requerido en Gii antes de Vista previa.

- Las rutas de origen relativas comienzan en `source['dir']`; las rutas que comienzan con un alias Yii usan ese alias. Una ruta de origen sin una extensión recibe `source['ext']`, cuyo valor predeterminado es `.tpl`.
- Las rutas de salida relativas comienzan en `@app`. Especifique explícitamente la extensión deseada; no se agrega ninguna extensión a las rutas de salida de plantilla ordinarias.
- Ambas rutas pueden contener [Marcadores](#yii2-file-crafter-using-Marks).

Un archivo `.tpl` normal se lee como texto y luego se reemplazan sus marcas. El PHP que contiene se copia en la salida, como en el Inicio rápido. Las plantillas PHP se procesan con `yii\web\View::renderFile` y reciben `$schema` y `$generator`; el reemplazo de marcas sigue a la renderización. La implementación actual selecciona la representación PHP cuando la ruta de origen contiene `.php`, por lo tanto, mantenga las plantillas de texto fuera de los directorios cuyos nombres contengan `.php`.

Por ejemplo, `templates/file-crafter/view.php` puede contener:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

Para `Product Items`, la salida es:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Campos personalizados

Las claves definen marcas personalizadas; los valores definen etiquetas en el editor de esquemas:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Para el esquema `Product Items`, ingrese `product` en **Singular name** y `products` en **Plural name**. Una plantilla de texto puede utilizar estos valores:

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Resultado:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Estado de autocompletar

`autoCompleteStatus` permite sugerencias integradas, personalizadas y de bases de datos para **Schema name**. Predeterminado: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Lista de autocompletar

`autoCompleteList` proporciona sugerencias de nombres de esquema personalizados cuando `autoCompleteStatus` es `true`. Valor predeterminado: una matriz vacía.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Estado de vista previa

`previewStatus` habilita la vista previa del contenido del esquema que se muestra al pasar el mouse sobre el icono. Valor predeterminado: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Eliminación de esquemas

`canDelete` controla la eliminación del esquema desde el panel. Valor predeterminado: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Analizar base de datos

`parseDataBase` importa nombres de tablas en sugerencias (`autocomplete`) y/o esquemas derivados de bases de datos en el panel (`fakeCache`). Valor predeterminado: una matriz vacía. Estas opciones requieren un componente de aplicación `db` configurado.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Comandos

`commands` es una lista de comandos CLI con reemplazo de [Marcadores](#yii2-file-crafter-using-Marks). Valor predeterminado: una matriz vacía. Los comandos se ejecutan para cada esquema seleccionado en un envío **Generate** explícito con archivos seleccionados, antes de representar sus plantillas configuradas. **Preview** nunca los ejecuta.

Para una aplicación con el módulo de consola Gii configurado, una tabla existente y un espacio de nombres `common\models`, este comando genera su modelo ActiveRecord:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Los comandos se ejecutan en el directorio de trabajo del proceso PHP. Ajuste el ejecutable PHP, la ruta del script de entrada de la consola y el espacio de nombres para la aplicación. Los comandos pueden modificar archivos independientemente de los archivos seleccionados en Gii.

<span id="yii2-file-crafter-using-Events"></span>

## Eventos

`eventHandler` adjunta un comportamiento Yii al generador. Predeterminado: `null`. Cree `components/behaviors/FileCrafterBehavior.php` en la aplicación:

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

Habilite el comportamiento en la configuración mínima:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

En una aplicación Advanced, ajuste el espacio de nombres y la configuración del comportamiento para que coincida con su ubicación, por ejemplo, `backend\components\behaviors`. Se requiere el mapa `events()`: los nombres de los métodos del controlador por sí solos no se suscriben a los eventos.

Todos los eventos exponen `options`. Antes de la generación, el evento contiene `listSchemaDto` y el `generateList` resuelto; Los controladores pueden cambiar los nombres de las tablas seleccionadas. Después de la generación, el evento contiene `files` (`yii\gii\CodeFile[]`). Los eventos de renderizado exponen `schema`, `sourcePath`, `generatePath`, `replaceList` y `content`; `content` se completa después del renderizado.

Los eventos de comando exponen `cmd`, una instancia de `andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): comando tras sustitución de marca.
- `output` (`?string`): `null` antes de la ejecución, salida del comando después.
- `replaceList` (`array`): marca el mapa de reemplazo para el esquema.

<span id="yii2-file-crafter-schema"></span>

## Edición y generación de esquemas.

El editor de esquema acepta valores enum/set como una matriz JSON de cadenas, por ejemplo `["draft", "published", "owner's"]`. Las listas no válidas se informan antes de guardar el esquema. Los esquemas heredados no válidos se informan en Vista previa en lugar de provocar una excepción.

La vista previa nunca ejecuta comandos CLI configurados. Los comandos se ejecutan solo para un envío Generar explícito con archivos seleccionados. Los nombres de archivos de migración conservan la marca de tiempo enviada por el formulario de vista previa, incluso cuando la Generación ocurre en un minuto posterior.

Las importaciones de bases de datos conservan claves primarias y externas, acciones referenciales, índices, escala decimal, incremento automático, indicadores sin firmar y valores predeterminados de columnas en el esquema almacenado en caché. Las claves foráneas se crean con la tabla; Las tablas a las que se hace referencia ya deben existir. Como ocurre con todas las migraciones generadas, revisa el resultado antes de aplicarlo.

<span id="yii2-file-crafter-tests"></span>

## Pruebas

Las dependencias de desarrollo de PHPUnit requieren PHP 8.1 o posterior y las extensiones `dom`, `mbstring` y `pdo_sqlite`. Ejecute estos comandos desde un clon de este repositorio:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

Para verificar solo el archivo README:

```sh
composer test:docs
```

Las pruebas de documentación leen ejemplos directamente de este archivo. Verifican la sintaxis de PHP, la configuración del generador, el flujo de vista previa/generación del inicio rápido, la representación de plantillas, las marcas, las suscripciones a eventos, los anclajes de secciones únicas y los enlaces internos. No ejecutan los comandos CLI específicos de la aplicación documentados ni solicitan sitios web externos.

La suite predeterminada utiliza archivos temporales y una base de datos SQLite en memoria. Para habilitar la prueba de regresión MySQL, proporcione una base de datos de prueba desechable y la extensión `pdo_mysql`:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

Las pruebas de MySQL crean y eliminan sólo sus propias tablas con nombres aleatorios. Verifican claves importadas, valores decimales, valores predeterminados y cumplimiento de restricciones. Las pruebas del controlador Gii cubren mutaciones aisladas del generador, vista previa repetida, selección de migración a través de un límite de minutos y validación de formulario de enumeración/establecimiento. CI ejecuta la suite, incluidas las comprobaciones README, en PHP 8.1, 8.2, 8.4 y 8.5 con MySQL 8.4, y comprueba la sintaxis de PHP 8.0 por separado.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
