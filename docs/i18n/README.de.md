<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Codebeispiele und Beschriftungen der Benutzeroberfläche bleiben in allen Übersetzungen auf Englisch.

Yii2 File Crafter ist ein Gii-Generator zum Erstellen von Dateien aus wiederverwendbaren Vorlagen und benannten Schemas.

## Inhalt

- [Aufstellen](#yii2-file-crafter-setup)
- [Konfiguration und Schnellstart](#yii2-file-crafter-config)
- [Migrationen](#yii2-file-crafter-migrations)
- [Optionen und Vorlagen](#yii2-file-crafter-using)
- [Schemabearbeitung und -generierung](#yii2-file-crafter-schema)
- [Tests](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Aufstellen

Anforderungen: PHP 8.0 oder neuer, eine Yii 2-Anwendung und `yiisoft/yii2-gii`. Installieren Sie File Crafter und Gii als Entwicklungsabhängigkeiten in der Anwendung:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Ersetzen Sie für eine lokale Composer-Installation `composer` durch `php composer.phar`. Alternativ können Sie diese Einträge in das vorhandene `composer.json` der Anwendung einbinden:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Führen Sie dann Folgendes aus:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii muss in der Anwendung installiert sein: Composer installiert nicht die `require-dev`-Abhängigkeiten von Abhängigkeitspaketen. Siehe [Composer-Dokumentation](https://getcomposer.org/doc/04-schema.md#require-dev) und [Gii-Installationsanleitung](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Konfiguration und Schnellstart

Die Beispiele verwenden `$config` für das Konfigurationsarray der Anwendung. Fügen Sie in einer Basic-Anwendung die Mindestkonfiguration innerhalb des vorhandenen `if (YII_ENV_DEV)`-Blocks in `config/web.php` vor `return $config` hinzu. Führen Sie in einer Advanced-Anwendung dieselben Einträge in der Entwicklungskonfiguration der Anwendung zusammen, die Gii bedient, beispielsweise `backend/config/main-local.php`. Behalten Sie Gii nur einmal in `bootstrap` bei, wenn die Anwendung dies bereits aktiviert.

Mindestkonfiguration (erzeugt eine Servicedatei ohne Migration):

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

Erstellen Sie `templates/file-crafter/service.tpl` im Basisverzeichnis der Anwendung:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Öffnen Sie `http://localhost/index.php?r=gii/fileCrafter` und passen Sie den Host- und Eintragsskriptpfad für die Anwendung an.
2. Geben Sie `Product Items` in **Schema name** ein und klicken Sie auf **Create**. Datenbankattribute können für diese Vorlage leer bleiben.
3. Wählen Sie die Vorlagengruppe `default` und das gespeicherte Schema aus und klicken Sie dann auf **Preview**.
4. Überprüfen Sie das vorgeschlagene `services/ProductItemsService.php`, lassen Sie es ausgewählt und klicken Sie auf **Generate**.

Die resultierende Datei enthält:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` bezieht sich auf das Basisverzeichnis der ausgewählten Anwendung. Aliase wie `@backend` und `@frontend` erfordern eine Advanced-Anwendung oder eine explizite Aliaskonfiguration; Der Quick Start ist nicht von ihnen abhängig.

Die folgende alternative Konfiguration zeigt jede File Crafter-Option. Erstellen Sie die referenzierten Vorlagen, bevor Sie deren Gruppe auswählen. Nachfolgend werden die Optionen `commands` und `eventHandler` erläutert.

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

## Migrationen

Sofern `migration` nicht gleich `false` ist, wird für jedes ausgewählte Schema eine Migration zum Erstellen einer Tabelle generiert. Die Anwendung auf eine vorhandene Tabelle führt zu einem Fehler. Die bestehende Tabelle und ihre Daten bleiben erhalten. Änderungen an vorhandenen Tabellen erfordern eine explizite Migration mithilfe der Spalten- und Indexoperationen von Yii. Generierte Migrationen werden nicht automatisch angewendet.

Die in der vollständigen Konfiguration angezeigten `migration`-Einstellungen sind die Standardeinstellungen:

- `root`: Ausgabeverzeichnis, aufgelöst durch Yii-Aliase.
- `fileName`: Suffixmuster; `%s` wird durch den Tabellennamen des Schemas ersetzt. Ein Migrationszeitstempelpräfix und die Erweiterung `.php` werden automatisch hinzugefügt.
- `template`: PHP-Vorlage, die zum Rendern der Migration verwendet wird.

Alle unten aufgeführten Optionsbeispiele ändern die obige Mindestkonfiguration. So deaktivieren Sie Migrationen:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Optionen und Vorlagen

### Arbeiten mit Schemata

Erstellen Sie ein Schema mit **Create**. Wählen Sie das Bearbeitungssymbol aus, um ein gespeichertes Schema zu ändern oder umzubenennen, und verwenden Sie die Schaltfläche „Löschen“, um es zu entfernen, wenn `canDelete` aktiviert ist. Der Schemaname wird in einen Tabellennamen in Kleinbuchstaben umgewandelt: Leerzeichen werden zu Unterstrichen und andere Zeichen als ASCII-Buchstaben, Ziffern, Unterstriche und Leerzeichen werden entfernt. Gespeicherte Schemata sind JSON-Dateien im konfigurierten Cache-Verzeichnis; Behalten Sie diese Dateien bei, wenn Sie die Anwendung verschieben oder ihre Laufzeit löschen.

Das Panel unterstützt die Auswahl mehrerer Schemata und die gleichzeitige Auswahl aller Schemata. Eine leere Schemaauswahl führt dazu, dass der Generator alle verfügbaren Schemata verarbeitet. Die Vorschau zeigt die vorgeschlagenen Dateien. Generieren schreibt die ausgewählten Dateien. Eine fehlende Quellvorlage wird übersprungen. Überprüfen Sie daher den Quellpfad, wenn eine erwartete Datei fehlt.

### Datenbankfelder und Importe

Fügen Sie Felder im Schema-Editor hinzu, entfernen Sie sie und ordnen Sie sie neu an. Jedes Feld verfügt über einen Namen, einen Kommentar, einen Typ, eine Größe und die Flags `FK`, `UN` und `NN`. `UN` bedeutet eindeutig und `NN` bedeutet nicht null. Das `FK`-Flag allein definiert keine Fremdschlüsseleinschränkung; Die referenzierte Tabelle und die Spalten müssen in den Fremdschlüsselmetadaten des Schemas vorhanden sein. Feldnamen können einen Typ und Flags vorschlagen, die überprüft werden sollten.

Der Feldtypselektor bietet `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` und `set`. Die Datenbankunterstützung variiert je nach Typ und Treiber. Die Regressionssuite übt SQLite und MySQL aus; Es wird nicht für jeden Typ in jeder Datenbank Unterstützung bereitgestellt.

`parseDataBase` kann Tabellennamen zur automatischen Vervollständigung hinzufügen oder von der Datenbank abgeleitete Schemata mit `fakeCache` anzeigen. Letztere werden ohne Erstellung von JSON-Cache-Dateien angezeigt und können nicht über das Panel gelöscht werden. Für die automatische Vervollständigung der Datenbank muss `autoCompleteStatus` aktiviert sein.

### Anwenden und Anpassen von Migrationen

Generierte Migrationen müssen überprüft und über die Yii-Migrationsbefehle der Anwendung angewendet werden. Der generierte `safeDown()` löscht die erstellte Tabelle; Überprüfen Sie die Auswirkungen des Datenverlusts, bevor Sie eine Migration rückgängig machen. Eine benutzerdefinierte Migrationsvorlage kann `{{migrationClass}}` und `{{tableName}}` zusammen mit den Schema- und Generatorobjekten verwenden. Importierte Primärschlüssel, Fremdschlüssel und Indizes werden in Schema-Metadaten gespeichert; Einzelne Feldflags liefern keine referenzierte Tabelle oder Spalten.

Das Befehlsergebnis umfasst die Ausgabe und `resultCode`. Ein Befehls-Exit-Code ungleich Null wird gemeldet, stoppt jedoch nicht automatisch die Generierung konfigurierter Vorlagen.

- [Markierungen](#yii2-file-crafter-using-Marks)
- [Cache](#yii2-file-crafter-using-Cache)
- [Quelle](#yii2-file-crafter-using-Source)
- [Vorlagen](#yii2-file-crafter-using-Templates)
- [Benutzerdefinierte Felder](#yii2-file-crafter-using-CustomFields)
- [Status der automatischen Vervollständigung](#yii2-file-crafter-using-autoCompleteStatus)
- [Autovervollständigungsliste](#yii2-file-crafter-using-autoCompleteList)
- [Vorschaustatus](#yii2-file-crafter-using-previewStatus)
- [Kann löschen](#yii2-file-crafter-using-canDelete)
- [Datenbank analysieren](#yii2-file-crafter-using-parseDataBase)
- [Befehle](#yii2-file-crafter-using-Commands)
- [Ereignisse](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Markierungen

Markierungen werden in Vorlageninhalten, Pfaden und Befehlen ersetzt. Verwenden Sie doppelte geschweifte Klammern mit der genauen Schreibweise unten. Für ein Schema namens `Product Items`:

| Mark | Ergebnis |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Bei Groß- und Kleinschreibung wird der normalisierte Tabellenname einschließlich Unterstrichen verwendet. Benutzerdefinierte Felder verwenden dieselbe Syntax, zum Beispiel `{{singular}}`; siehe [Benutzerdefinierte Felder](#yii2-file-crafter-using-CustomFields). Unbekannte Markierungen bleiben unverändert. Überprüfen Sie daher die Dateinamen in der Vorschau.

<span id="yii2-file-crafter-using-Cache"></span>

## Cache

Schemata werden als JSON-Dateien gespeichert. Standard-Cache-Einstellungen:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Quelle

Standardquelleneinstellungen (der Schnellstart hat Vorrang vor `dir`):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Vorlagen

`templates` ordnet Gruppennamen Arrays von Quellvorlagenpfaden und Ausgabepfaden zu:

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

Wählen Sie vor der Vorschau die erforderliche Gruppe in Gii aus.

- Relative Quellpfade beginnen bei `source['dir']`; Pfade, die mit einem Yii-Alias ​​beginnen, verwenden diesen Alias. Ein Quellpfad ohne Erweiterung erhält `source['ext']`, der standardmäßig `.tpl` lautet.
- Relative Ausgabepfade beginnen bei `@app`. Geben Sie die gewünschte Erweiterung explizit an; Den gewöhnlichen Vorlagenausgabepfaden wird keine Erweiterung hinzugefügt.
- Beide Pfade können [Markierungen](#yii2-file-crafter-using-Marks) enthalten.

Eine reguläre `.tpl`-Datei wird als Text gelesen und dann werden ihre Markierungen ersetzt. Das darin enthaltene PHP wird wie im Quick Start in die Ausgabe kopiert. PHP-Vorlagen werden mit `yii\web\View::renderFile` gerendert und erhalten `$schema` und `$generator`; Der Markenaustausch folgt dem Rendern. Die aktuelle Implementierung wählt PHP-Rendering aus, wenn der Quellpfad `.php` enthält. Bewahren Sie daher Textvorlagen außerhalb von Verzeichnissen auf, deren Namen `.php` enthalten.

Beispielsweise kann `templates/file-crafter/view.php` Folgendes enthalten:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

Für `Product Items` lautet die Ausgabe:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Benutzerdefinierte Felder

Die Tasten definieren benutzerdefinierte Markierungen; Die Werte definieren Beschriftungen im Schema-Editor:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Geben Sie für das Schema `Product Items` `product` in **Singular name** und `products` in **Plural name** ein. Eine Textvorlage kann diese Werte verwenden:

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Ergebnis:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Status der automatischen Vervollständigung

`autoCompleteStatus` ermöglicht integrierte, benutzerdefinierte und Datenbankvorschläge für **Schema name**. Standard: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Autovervollständigungsliste

`autoCompleteList` stellt benutzerdefinierte Schemanamenvorschläge bereit, wenn `autoCompleteStatus` `true` ist. Standard: ein leeres Array.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Vorschaustatus

`previewStatus` aktiviert die Vorschau des Schemainhalts, die beim Bewegen des Symbols angezeigt wird. Standard: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Kann löschen

`canDelete` steuert das Löschen des Schemas aus dem Panel. Standard: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Datenbank analysieren

`parseDataBase` importiert Tabellennamen in Vorschläge (`autocomplete`) und/oder von Datenbanken abgeleitete Schemata in das Panel (`fakeCache`). Standard: ein leeres Array. Für diese Optionen ist eine konfigurierte `db`-Anwendungskomponente erforderlich.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Befehle

`commands` ist eine Liste von CLI-Befehlen mit [Markierungen](#yii2-file-crafter-using-Marks)-Ersatz. Standard: ein leeres Array. Befehle werden für jedes ausgewählte Schema bei einer expliziten **Generate**-Übermittlung mit ausgewählten Dateien ausgeführt, bevor die konfigurierten Vorlagen gerendert werden. **Preview** führt sie nie aus.

Für eine Anwendung mit konfiguriertem Gii-Konsolenmodul, einer vorhandenen Tabelle und einem `common\models`-Namespace generiert dieser Befehl ihr ActiveRecord-Modell:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Befehle werden im Arbeitsverzeichnis des PHP-Prozesses ausgeführt. Passen Sie die ausführbare PHP-Datei, den Pfad zum Konsoleneintragsskript und den Namespace für die Anwendung an. Befehle können Dateien unabhängig von den in Gii ausgewählten Dateien ändern.

<span id="yii2-file-crafter-using-Events"></span>

## Ereignisse

`eventHandler` fügt dem Generator ein Yii-Verhalten hinzu. Standard: `null`. Erstellen Sie `components/behaviors/FileCrafterBehavior.php` in der Anwendung:

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

Aktivieren Sie das Verhalten in der Mindestkonfiguration:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

Passen Sie in einer Advanced-Anwendung den Namespace und die Konfiguration des Verhaltens an seinen Speicherort an, z. B. `backend\components\behaviors`. Die Zuordnung `events()` ist erforderlich: Handler-Methodennamen allein abonnieren keine Ereignisse.

Alle Ereignisse machen `options` verfügbar. Vor der Generierung enthält das Ereignis `listSchemaDto` und das aufgelöste `generateList`; Handler können die ausgewählten Tabellennamen ändern. Nach der Generierung enthält das Ereignis `files` (`yii\gii\CodeFile[]`). Renderereignisse machen `schema`, `sourcePath`, `generatePath`, `replaceList` und `content` verfügbar; `content` wird nach dem Rendern gefüllt.

Befehlsereignisse machen `cmd` verfügbar, eine Instanz von `andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): Befehl nach Markenersetzung.
- `output` (`?string`): `null` vor der Ausführung, Befehlsausgabe danach.
- `replaceList` (`array`): Ersetzungszuordnung für das Schema markieren.

<span id="yii2-file-crafter-schema"></span>

## Schemabearbeitung und -generierung

Der Schema-Editor akzeptiert Enum-/Set-Werte als JSON-Array von Zeichenfolgen, zum Beispiel `["draft", "published", "owner's"]`. Ungültige Listen werden vor dem Speichern des Schemas gemeldet. Ungültige Legacy-Schemata werden in der Vorschau gemeldet, anstatt eine Ausnahme auszulösen.

Preview führt niemals konfigurierte CLI-Befehle aus. Befehle werden nur für eine explizite Übermittlung mit ausgewählten Dateien ausgeführt. Migrationsdateinamen behalten den vom Vorschauformular übermittelten Zeitstempel bei, auch wenn die Generierung zu einem späteren Zeitpunkt erfolgt.

Datenbankimporte behalten Primär- und Fremdschlüssel, referenzielle Aktionen, Indizes, Dezimalskalierung, automatische Inkrementierung, vorzeichenlose Flags und Spaltenstandards im zwischengespeicherten Schema bei. Fremdschlüssel werden mit der Tabelle erstellt; Referenzierte Tabellen müssen bereits vorhanden sein. Überprüfen Sie wie bei allen generierten Migrationen das Ergebnis, bevor Sie es anwenden.

<span id="yii2-file-crafter-tests"></span>

## Tests

Die PHPUnit-Entwicklungsabhängigkeiten erfordern PHP 8.1 oder neuer und die Erweiterungen `dom`, `mbstring` und `pdo_sqlite`. Führen Sie diese Befehle von einem Klon dieses Repositorys aus:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

So überprüfen Sie nur die README-Datei:

```sh
composer test:docs
```

Die Dokumentationstests lesen Beispiele direkt aus dieser Datei. Sie überprüfen die PHP-Syntax, die Generatorkonfiguration, den Vorschau-/Generierungsablauf des Quick Starts, das Rendern von Vorlagen, Markierungen, Ereignisabonnements, eindeutige Abschnittsanker und interne Links. Sie führen nicht die dokumentierten anwendungsspezifischen CLI-Befehle aus und fordern keine externen Websites an.

Die Standardsuite verwendet temporäre Dateien und eine speicherinterne SQLite-Datenbank. Um den MySQL-Regressionstest zu aktivieren, stellen Sie eine verfügbare Testdatenbank und die Erweiterung `pdo_mysql` bereit:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

Die MySQL-Tests erstellen und entfernen nur ihre eigenen, zufällig benannten Tabellen. Sie überprüfen importierte Schlüssel, Dezimalwerte, Standardwerte und die Durchsetzung von Einschränkungen. Gii-Controller-Tests umfassen isolierte Generatormutationen, wiederholte Vorschau, Migrationsauswahl über eine Minutengrenze hinweg und Enumerations-/Set-Formularvalidierung. CI führt die Suite, einschließlich der README-Prüfungen, auf PHP 8.1, 8.2, 8.4 und 8.5 mit MySQL 8.4 aus und prüft die PHP 8.0-Syntax separat.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
