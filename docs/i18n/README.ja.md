<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

すべての翻訳で、コード例と画面上のラベルは英語のままにしています。

Yii2 File Crafter は、再利用可能なテンプレートと名前付きスキーマからファイルを作成するための Gii ジェネレーターです。

## コンテンツ

- [設定](#yii2-file-crafter-setup)
- [設定とクイックスタート](#yii2-file-crafter-config)
- [移行](#yii2-file-crafter-migrations)
- [オプションとテンプレート](#yii2-file-crafter-using)
- [スキーマの編集と生成](#yii2-file-crafter-schema)
- [テスト](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## 設定

要件: PHP 8.0 以降、Yii 2 アプリケーション、および `yiisoft/yii2-gii`。 File Crafter と Gii を開発依存関係としてアプリケーションにインストールします。

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

ローカル Composer インストールの場合は、`composer` を `php composer.phar` に置き換えます。あるいは、これらのエントリをアプリケーションの既存の `composer.json` にマージします。

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

次に、次を実行します。

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii はアプリケーションにインストールする必要があります。Composer は、依存関係パッケージの `require-dev` 依存関係をインストールしません。 [Composer のドキュメント](https://getcomposer.org/doc/04-schema.md#require-dev) および [Gii のインストールガイド](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation) を参照してください。

<span id="yii2-file-crafter-config"></span>

## 設定とクイックスタート

例では、 `$config` アプリケーションの構成配列の場合。で Basic アプリケーションに最小限の構成を既存のアプリケーション内に追加します `if (YII_ENV_DEV)` ブロックイン `config/web.php`、 前に `return $config`。で Advanced アプリケーションを実行する場合、同じエントリをサービスを提供するアプリケーションの開発構成にマージします。 Gii、 例えば `backend/config/main-local.php`。保つ Gii で `bootstrap` アプリケーションがすでに有効にしている場合は 1 回だけ。

最小構成 (移行せずにサービス ファイルを生成):

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

アプリケーションのベース ディレクトリに `templates/file-crafter/service.tpl` を作成します。

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. `http://localhost/index.php?r=gii/fileCrafter` を開き、アプリケーションのホストとエントリ スクリプト パスを調整します。
2. 入力 `Product Items` で **Schema name** そしてクリックしてください **Create**。このテンプレートのデータベース属性は空のままにすることができます。
3. `default` テンプレート グループと保存されたスキーマを選択し、**Preview** をクリックします。
4. 提案された `services/ProductItemsService.php` をチェックし、選択したままにして、**Generate** をクリックします。

結果のファイルには次の内容が含まれます。

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` は、選択したアプリケーションのベース ディレクトリを指します。 `@backend` や `@frontend` などのエイリアスには、Advanced アプリケーションまたは明示的なエイリアス構成が必要です。クイック スタートはそれらに依存しません。

次の代替構成は、すべての File Crafter オプションを示しています。グループを選択する前に、参照されるテンプレートを作成します。 `commands` および `eventHandler` オプションについては以下で説明します。

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

## 移行

`migration` が `false` でない限り、選択したスキーマごとにテーブル作成移行が生成されます。これを既存のテーブルに適用すると、エラーが発生します。既存のテーブルとそのデータは保持されます。既存のテーブルを変更するには、Yii のカラムとインデックスの操作を使用して明示的に移行する必要があります。生成された移行は自動的には適用されません。

完全な構成に示されている `migration` 設定はデフォルトです。

- `root`: 出力ディレクトリ。Yii エイリアスを通じて解決されます。
- `fileName`: サフィックスパターン; `%s` はスキーマのテーブル名に置き換えられます。移行タイムスタンプのプレフィックスと `.php` 拡張子が自動的に追加されます。
- `template`: 移行のレンダリングに使用される PHP テンプレート。

以下のすべてのオプション例は、上記の最小構成を変更します。移行を無効にするには:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## オプションとテンプレート

### スキーマの操作

**Create** でスキーマを作成します。編集アイコンを選択して保存されたスキーマを変更または名前変更し、`canDelete` が有効な場合に削除ボタンを使用して削除します。スキーマ名は小文字のテーブル名に変換されます。スペースはアンダースコアになり、ASCII 文字、数字、アンダースコア、空白以外の文字は削除されます。保存されたスキーマは、構成されたキャッシュ ディレクトリ内の JSON ファイルです。アプリケーションを移動するとき、またはランタイムをクリアするときに、これらのファイルを保持します。

このパネルでは、複数のスキーマの選択と一度にすべてのスキーマの選択がサポートされています。空のスキーマを選択すると、ジェネレーターは使用可能なすべてのスキーマを処理します。プレビューには提案されたファイルが表示されます。 Generate は選択したファイルを書き込みます。不足しているソース テンプレートはスキップされるため、予期したファイルが存在しない場合はソース パスを確認してください。

### データベースフィールドとインポート

スキーマエディターでフィールドを追加、削除、並べ替えます。各フィールドには、名前、コメント、タイプ、サイズ、および `FK`、`UN`、および `NN` フラグがあります。 `UN` は一意であることを意味し、`NN` は null ではないことを意味します。 `FK` フラグだけでは外部キー制約を定義しません。参照されるテーブルと列は、スキーマの外部キー メタデータに存在する必要があります。フィールド名はタイプとフラグを示唆している可能性があるため、確認する必要があります。

フィールド タイプ セレクターは、`string`、`int`、`boolean`、`text`、`timestamp`、`datetime`、`date`、`time`、`json`、 `float`、`double`、`decimal`、`jsonb`、`binary`、`money`、`smallint`、`bigint`、`char`、 `varchar`、`tinyint`、`enum`、`set`。データベースのサポートはタイプとドライバーによって異なります。回帰スイートは SQLite と MySQL を実行します。すべてのデータベースですべてのタイプのサポートを確立するわけではありません。

`parseDataBase` では、オートコンプリートするテーブル名を追加したり、`fakeCache` でデータベース由来のスキーマを表示したりできます。後者は、JSON キャッシュ ファイルを作成せずに表示され、パネルから削除することはできません。データベースのオートコンプリートを使用するには、`autoCompleteStatus` を有効にする必要があります。

### 移行の適用とカスタマイズ

生成されたマイグレーションは、アプリケーションの Yii マイグレーションコマンドを通じてレビューして適用する必要があります。生成された `safeDown()` は、作成されたテーブルを削除します。移行をロールバックする前に、データ損失の影響を確認してください。カスタム移行テンプレートでは、`{{migrationClass}}` および `{{tableName}}` をスキーマ オブジェクトおよびジェネレーター オブジェクトとともに使用できます。インポートされた主キー、外部キー、インデックスはスキーマ メタデータに保存されます。個々のフィールド フラグは、参照されるテーブルまたは列を提供しません。

コマンドの結果には、出力と `resultCode` が含まれます。ゼロ以外のコマンド終了コードが報告されますが、それ自体は構成済みテンプレートの生成を停止しません。

- [マーク](#yii2-file-crafter-using-Marks)
- [キャッシュ](#yii2-file-crafter-using-Cache)
- [ソース](#yii2-file-crafter-using-Source)
- [テンプレート](#yii2-file-crafter-using-Templates)
- [カスタムフィールド](#yii2-file-crafter-using-CustomFields)
- [オートコンプリートのステータス](#yii2-file-crafter-using-autoCompleteStatus)
- [オートコンプリートリスト](#yii2-file-crafter-using-autoCompleteList)
- [プレビューステータス](#yii2-file-crafter-using-previewStatus)
- [削除できます](#yii2-file-crafter-using-canDelete)
- [データベースを解析する](#yii2-file-crafter-using-parseDataBase)
- [コマンド](#yii2-file-crafter-using-Commands)
- [イベント](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## マーク

マークは、テンプレートのコンテンツ、パス、コマンドで置き換えられます。以下に示す正確なスペルで二重中括弧を使用してください。 `Product Items` という名前のスキーマの場合:

|マーク |結果 |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

大文字と小文字では、アンダースコアを含む正規化されたテーブル名が使用されます。カスタム フィールドは同じ構文を使用します (例: `{{singular}}`)。 [カスタムフィールド](#yii2-file-crafter-using-CustomFields)を参照してください。不明なマークは変更されないため、プレビューでファイル名を確認してください。

<span id="yii2-file-crafter-using-Cache"></span>

## キャッシュ

スキーマは JSON ファイルとして保存されます。デフォルトのキャッシュ設定:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## ソース

デフォルトのソース設定 (クイック スタートは `dir` をオーバーライドします):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## テンプレート

`templates` は、グループ名をソース テンプレート パスと出力パスの配列にマップします。

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

プレビューする前に、Gii で必要なグループを選択します。

- 相対ソース パスは `source['dir']` で始まります。 Yii エイリアスで始まるパスはそのエイリアスを使用します。拡張子のないソース パスは `source['ext']` を受け取ります。デフォルトは `.tpl` です。
- 相対出力パスは `@app` で始まります。目的の拡張子を明示的に指定します。通常のテンプレート出力パスには拡張子は追加されません。
- 両方のパスに [マーク](#yii2-file-crafter-using-Marks) が含まれる場合があります。

通常の `.tpl` ファイルはテキストとして読み取られ、そのマークが置き換えられます。クイック スタートと同様に、内部の PHP が出力にコピーされます。 PHP テンプレートは `yii\web\View::renderFile` でレンダリングされ、`$schema` および `$generator` を受け取ります。レンダリングの後にマークの置換が行われます。現在の実装では、ソース パスに `.php` が含まれる場合に PHP レンダリングが選択されるため、テキスト テンプレートは名前に `.php` が含まれるディレクトリの外に保管してください。

たとえば、`templates/file-crafter/view.php` には次の内容を含めることができます。

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

`Product Items` の場合、出力は次のようになります。

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## カスタムフィールド

キーはカスタム マークを定義します。値はスキーマ エディターでラベルを定義します。

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

スキーマの場合 `Product Items`、 入力 `product` で **Singular name** そして `products` で **Plural name**。テキスト テンプレートでは次の値を使用できます。

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

結果：

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## オートコンプリートのステータス

`autoCompleteStatus` は、**Schema name** の組み込み、カスタム、およびデータベースの提案を有効にします。デフォルト: `false`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## オートコンプリートリスト

`autoCompleteList` は、`autoCompleteStatus` が `true` の場合にカスタムのスキーマ名の提案を提供します。デフォルト: 空の配列。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## プレビューステータス

`previewStatus` は、アイコン ホバーに表示されるスキーマ コンテンツのプレビューを有効にします。デフォルト: `true`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## 削除できます

`canDelete` は、パネルからのスキーマの削除を制御します。デフォルト: `true`。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## データベースを解析する

`parseDataBase` は、テーブル名を提案 (`autocomplete`) にインポートするか、データベースから派生したスキーマをパネル (`fakeCache`) にインポートします。デフォルト: 空の配列。これらのオプションには、構成された `db` アプリケーション コンポーネントが必要です。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## コマンド

`commands` は、[マーク](#yii2-file-crafter-using-Marks) を置き換えた CLI コマンドのリストです。デフォルト: 空の配列。コマンドは、構成されたテンプレートをレンダリングする前に、選択したファイルを含む明示的な **Generate** 送信で、選択したスキーマごとに実行されます。 **Preview** はそれらを実行しません。

Gii コンソール モジュールが構成され、既存のテーブルと `common\models` 名前空間を持つアプリケーションの場合、このコマンドは ActiveRecord モデルを生成します。

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

コマンドは、PHP プロセスの作業ディレクトリで実行されます。アプリケーションの PHP 実行可能ファイル、コンソール エントリ スクリプト パス、および名前空間を調整します。コマンドは、Gii で選択されたファイルとは独立してファイルを変更できます。

<span id="yii2-file-crafter-using-Events"></span>

## イベント

`eventHandler` は、Yii ビヘイビアーをジェネレーターにアタッチします。デフォルト: `null`。アプリケーションで `components/behaviors/FileCrafterBehavior.php` を作成します。

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

最小構成で動作を有効にします。

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

Advanced アプリケーションでは、動作の名前空間と構成をその場所に一致するように調整します (例: `backend\components\behaviors`)。 `events()` マップが必要です。ハンドラー メソッド名だけではイベントをサブスクライブしません。

すべてのイベントは `options` を公開します。生成前、イベントには `listSchemaDto` と解決された `generateList` が含まれています。ハンドラーは、選択されたテーブル名を変更できます。生成後、イベントには `files` (`yii\gii\CodeFile[]`) が含まれます。レンダリング イベントは、`schema`、`sourcePath`、`generatePath`、`replaceList`、および `content` を公開します。 `content` はレンダリング後に設定されます。

コマンドイベントが公開する `cmd`、のインスタンス `andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): マーク置換後のコマンド。
- `output` (`?string`): 実行前は `null`、コマンドはその後出力されます。
- `replaceList` (`array`): スキーマの置換マップをマークします。

<span id="yii2-file-crafter-schema"></span>

## スキーマの編集と生成

スキーマ エディターは、列挙値/セット値を文字列の JSON 配列 (たとえば、`["draft", "published", "owner's"]`) として受け入れます。無効なリストは、スキーマを保存する前に報告されます。従来の無効なスキーマは、例外が発生するのではなく、プレビューで報告されます。

プレビューでは、設定された CLI コマンドが実行されることはありません。コマンドは、選択したファイルを使用した明示的な生成送信に対してのみ実行されます。移行ファイル名には、後で生成が行われる場合も含め、プレビュー フォームによって送信されたタイムスタンプが保持されます。

データベースのインポートでは、キャッシュされたスキーマ内の主キーと外部キー、参照アクション、インデックス、10 進数スケール、自動インクリメント、符号なしフラグ、および列のデフォルトが保持されます。外部キーはテーブルとともに作成されます。参照されるテーブルはすでに存在している必要があります。生成されたすべての移行と同様に、適用する前に結果を確認してください。

<span id="yii2-file-crafter-tests"></span>

## テスト

PHPUnit 開発の依存関係には、PHP 8.1 以降と、`dom`、`mbstring`、および `pdo_sqlite` 拡張機能が必要です。このリポジトリのクローンから次のコマンドを実行します。

```sh
composer update --prefer-stable --prefer-dist
composer test
```

README のみを確認するには:

```sh
composer test:docs
```

ドキュメント テストでは、このファイルからサンプルを直接読み取ります。これらは、PHP 構文、ジェネレーター構成、クイック スタートのプレビュー/生成フロー、テンプレート レンダリング、マーク、イベント サブスクリプション、固有のセクション アンカー、および内部リンクをチェックします。文書化されたアプリケーション固有の CLI コマンドを実行したり、外部 Web サイトを要求したりすることはありません。

デフォルトのスイートは、一時ファイルとメモリ内の SQLite データベースを使用します。 MySQL 回帰テストを有効にするには、使い捨てのテスト データベースと `pdo_mysql` 拡張機能を提供します。

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

MySQL テストは、ランダムに名前が付けられた独自のテーブルのみを作成および削除します。インポートされたキー、10 進数値、デフォルト、制約の適用をチェックします。 Gii コントローラー テストは、分離されたジェネレーターの突然変異、繰り返しのプレビュー、細かい境界を越えた移行の選択、列挙型/セット フォームの検証をカバーします。 CI は、README チェックを含むスイートを MySQL 8.4 を使用する PHP 8.1、8.2、8.4、および 8.5 上で実行し、PHP 8.0 の構文を個別にチェックします。

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
