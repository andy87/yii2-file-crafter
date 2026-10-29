<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Les exemples de code et les libellés de l’interface restent en anglais dans toutes les traductions.

Yii2 File Crafter est un générateur Gii permettant de créer des fichiers à partir de modèles réutilisables et de schémas nommés.

## Contenu

- [Installation](#yii2-file-crafter-setup)
- [Configuration et démarrage rapide](#yii2-file-crafter-config)
- [Migrations](#yii2-file-crafter-migrations)
- [Options et modèles](#yii2-file-crafter-using)
- [Édition et génération de schémas](#yii2-file-crafter-schema)
- [Essais](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Installation

Exigences : PHP 8.0 ou version ultérieure, une application Yii 2 et `yiisoft/yii2-gii`. Installez File Crafter et Gii en tant que dépendances de développement dans l'application :

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Pour une installation locale de Composer, remplacez `composer` par `php composer.phar`. Vous pouvez également fusionner ces entrées dans le `composer.json` existant de l'application :

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Puis exécutez :

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii doit être installé dans l'application : Composer n'installe pas les dépendances `require-dev` des packages de dépendances. Voir les modèles [Documentation de Composer](https://getcomposer.org/doc/04-schema.md#require-dev) et [Guide d’installation de Gii](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Configuration et démarrage rapide

Les exemples utilisent `$config` pour le tableau de configuration de l'application. Dans une application Basic, ajoutez la configuration minimale à l'intérieur du bloc `if (YII_ENV_DEV)` existant dans `config/web.php`, avant `return $config`. Dans une application Advanced, fusionnez les mêmes entrées dans la configuration de développement de l'application qui dessert Gii, par exemple `backend/config/main-local.php`. Conservez Gii dans `bootstrap` une seule fois si l'application l'autorise déjà.

Configuration minimale (génère un fichier de service sans migration) :

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

Créez `templates/file-crafter/service.tpl` sous le répertoire de base de l'application :

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Ouvrez `http://localhost/index.php?r=gii/fileCrafter`, en ajustant le chemin de l'hôte et du script d'entrée pour l'application.
2. Entrez `Product Items` dans **Schema name** et cliquez sur **Create**. Les attributs de la base de données peuvent être laissés vides pour ce modèle.
3. Sélectionnez le groupe de modèles `default` et le schéma enregistré, puis cliquez sur **Preview**.
4. Vérifiez le `services/ProductItemsService.php` proposé, conservez-le sélectionné et cliquez sur **Generate**.

Le fichier résultant contient :

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` fait référence au répertoire de base de l'application sélectionnée. Les alias tels que `@backend` et `@frontend` nécessitent une application Advanced ou une configuration d'alias explicite ; le Quick Start n’en dépend pas.

La configuration alternative suivante montre chaque option File Crafter. Créez les modèles référencés avant de sélectionner leur groupe. Les options `commands` et `eventHandler` sont expliquées ci-dessous.

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

Sauf si `migration` est `false`, une migration de création de table est générée pour chaque schéma sélectionné. L'appliquer à une table existante génère une erreur. La table existante et ses données sont conservées. Les modifications apportées aux tables existantes nécessitent une migration explicite à l'aide des opérations de colonne et d'index de Yii. Les migrations générées ne sont pas appliquées automatiquement.

Les paramètres `migration` affichés dans la configuration complète sont les paramètres par défaut :

- `root` : répertoire de sortie, résolu via les alias Yii.
- `fileName` : modèle de suffixe ; `%s` est remplacé par le nom de table du schéma. Un préfixe d’horodatage de migration et une extension `.php` sont ajoutés automatiquement.
- `template` : modèle PHP utilisé pour le rendu de la migration.

Tous les exemples d'options ci-dessous modifient la configuration minimale ci-dessus. Pour désactiver les migrations :

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Options et modèles

### Travailler avec des schémas

Créez un schéma avec **Create**. Sélectionnez l'icône d'édition pour modifier ou renommer un schéma enregistré, et utilisez le bouton Supprimer pour le supprimer lorsque `canDelete` est activé. Le nom du schéma est converti en nom de table en minuscules : les espaces deviennent des traits de soulignement et les caractères autres que les lettres ASCII, les chiffres, les traits de soulignement et les espaces sont supprimés. Les schémas enregistrés sont des fichiers JSON dans le répertoire de cache configuré ; conserver ces fichiers lors du déplacement de l'application ou de la suppression de son environnement d'exécution.

Le panneau prend en charge la sélection de plusieurs schémas et la sélection simultanée de tous. Une sélection de schéma vide amène le générateur à traiter tous les schémas disponibles. L'aperçu affiche les fichiers proposés ; Générer écrit les fichiers sélectionnés. Un modèle source manquant est ignoré, vérifiez donc le chemin source si un fichier attendu est absent.

### Champs de base de données et importations

Ajoutez, supprimez et réorganisez les champs dans l'éditeur de schéma. Chaque champ a un nom, un commentaire, un type, une taille et des indicateurs `FK`, `UN` et `NN`. `UN` signifie unique et `NN` signifie non nul. L'indicateur `FK` à lui seul ne définit pas de contrainte de clé étrangère ; la table et les colonnes référencées doivent être présentes dans les métadonnées de clé étrangère du schéma. Les noms de champs peuvent suggérer un type et des indicateurs qui doivent être examinés.

Le sélecteur de type de champ propose `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` et `set`. La prise en charge des bases de données varie selon le type et le pilote. La suite de régression exerce SQLite et MySQL ; il n'établit pas de prise en charge pour chaque type sur chaque base de données.

`parseDataBase` peut ajouter des noms de tables à compléter automatiquement ou afficher des schémas dérivés de bases de données avec `fakeCache`. Ces derniers sont affichés sans créer de fichiers cache JSON et ne peuvent pas être supprimés via le panneau. La saisie semi-automatique de la base de données nécessite que `autoCompleteStatus` soit activé.

### Appliquer et personnaliser les migrations

Les migrations générées doivent être examinées et appliquées via les commandes de migration Yii de l'application. Le `safeDown()` généré supprime la table créée ; examinez l’impact de la perte de données avant d’annuler une migration. Un modèle de migration personnalisé peut utiliser `{{migrationClass}}` et `{{tableName}}` ainsi que les objets schéma et générateur. Les clés primaires, les clés étrangères et les index importés sont stockés dans les métadonnées du schéma ; les indicateurs de champ individuels ne fournissent pas de table ou de colonnes référencées.

Le résultat de la commande inclut la sortie et `resultCode`. Un code de sortie de commande différent de zéro est signalé mais n'arrête pas en soi la génération des modèles configurés.

- [Marques](#yii2-file-crafter-using-Marks)
- [Cache](#yii2-file-crafter-using-Cache)
- [Source](#yii2-file-crafter-using-Source)
- [Modèles](#yii2-file-crafter-using-Templates)
- [Champs personnalisés](#yii2-file-crafter-using-CustomFields)
- [Statut de saisie semi-automatique](#yii2-file-crafter-using-autoCompleteStatus)
- [Liste de saisie semi-automatique](#yii2-file-crafter-using-autoCompleteList)
- [État de l'aperçu](#yii2-file-crafter-using-previewStatus)
- [Peut supprimer](#yii2-file-crafter-using-canDelete)
- [Analyser la base de données](#yii2-file-crafter-using-parseDataBase)
- [Commandes](#yii2-file-crafter-using-Commands)
- [Événements](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Marques

Les marques sont remplacées dans le contenu, les chemins et les commandes du modèle. Utilisez des accolades doubles avec l’orthographe exacte indiquée ci-dessous. Pour un schéma nommé `Product Items` :

| Marque | Résultat |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Les majuscules et les minuscules utilisent le nom de table normalisé, y compris les traits de soulignement. Les champs personnalisés utilisent la même syntaxe, par exemple `{{singular}}` ; voir [Champs personnalisés](#yii2-file-crafter-using-CustomFields). Les marques inconnues restent inchangées, alors vérifiez les noms de fichiers dans Aperçu.

<span id="yii2-file-crafter-using-Cache"></span>

## Cache

Les schémas sont stockés sous forme de fichiers JSON. Paramètres de cache par défaut :

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Source

Paramètres de source par défaut (le démarrage rapide remplace `dir`) :

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Modèles

`templates` mappe les noms de groupe sur des tableaux de chemins de modèle source et de chemins de sortie :

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

Sélectionnez le groupe requis dans Gii avant l'aperçu.

- Les chemins sources relatifs commencent à `source['dir']` ; les chemins commençant par un alias Yii utilisent cet alias. Un chemin source sans extension reçoit `source['ext']`, qui est par défaut `.tpl`.
- Les chemins de sortie relatifs commencent à `@app`. Spécifiez explicitement l'extension souhaitée ; aucune extension n'est ajoutée aux chemins de sortie des modèles ordinaires.
- Les deux chemins peuvent contenir [Marques](#yii2-file-crafter-using-Marks).

Un fichier `.tpl` standard est lu sous forme de texte, puis ses marques sont remplacées. PHP qu'il contient est copié dans la sortie, comme dans le Quick Start. Les modèles PHP sont rendus avec `yii\web\View::renderFile` et reçoivent `$schema` et `$generator` ; le remplacement des marques suit le rendu. L'implémentation actuelle sélectionne le rendu PHP lorsque le chemin source contient `.php`, conservez donc les modèles de texte en dehors des répertoires dont les noms contiennent `.php`.

Par exemple, `templates/file-crafter/view.php` peut contenir :

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

Pour `Product Items`, le résultat est :

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Champs personnalisés

Les touches définissent des marques personnalisées ; les valeurs définissent des étiquettes dans l'éditeur de schéma :

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Pour le schéma `Product Items`, saisissez `product` dans **Singular name** et `products` dans **Plural name**. Un modèle de texte peut utiliser ces valeurs :

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Résultat:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Statut de saisie semi-automatique

`autoCompleteStatus` permet des suggestions intégrées, personnalisées et de base de données pour **Schema name**. Par défaut : `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Liste de saisie semi-automatique

`autoCompleteList` fournit des suggestions de noms de schéma personnalisées lorsque `autoCompleteStatus` est `true`. Par défaut : un tableau vide.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## État de l'aperçu

`previewStatus` active l'aperçu du contenu du schéma affiché au survol de l'icône. Par défaut : `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Peut supprimer

`canDelete` contrôle la suppression du schéma à partir du panneau. Par défaut : `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Analyser la base de données

`parseDataBase` importe les noms de table dans des suggestions (`autocomplete`) et/ou des schémas dérivés de bases de données dans le panneau (`fakeCache`). Par défaut : un tableau vide. Ces options nécessitent un composant d'application `db` configuré.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Commandes

`commands` est une liste de commandes CLI avec remplacement [Marques](#yii2-file-crafter-using-Marks). Par défaut : un tableau vide. Les commandes s'exécutent pour chaque schéma sélectionné sur une soumission explicite **Generate** avec les fichiers sélectionnés, avant de restituer ses modèles configurés. **Preview** ne les exécute jamais.

Pour une application avec le module de console Gii configuré, une table existante et un espace de noms `common\models`, cette commande génère son modèle ActiveRecord :

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Les commandes s'exécutent dans le répertoire de travail du processus PHP. Ajustez l'exécutable PHP, le chemin du script d'entrée de la console et l'espace de noms de l'application. Les commandes peuvent modifier les fichiers indépendamment des fichiers sélectionnés dans Gii.

<span id="yii2-file-crafter-using-Events"></span>

## Événements

`eventHandler` attache un comportement Yii au générateur. Par défaut : `null`. Créez `components/behaviors/FileCrafterBehavior.php` dans l'application :

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

Activez le comportement dans la configuration minimale :

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

Dans une application Advanced, ajustez l'espace de noms et la configuration du comportement en fonction de son emplacement, par exemple `backend\components\behaviors`. La carte `events()` est requise : les noms de méthodes de gestionnaire à eux seuls ne s'abonnent pas aux événements.

Tous les événements exposent `options`. Avant la génération, l'événement contient `listSchemaDto` et le `generateList` résolu ; les gestionnaires peuvent modifier les noms de table sélectionnés. Après génération, l'événement contient `files` (`yii\gii\CodeFile[]`). Les événements de rendu exposent `schema`, `sourcePath`, `generatePath`, `replaceList` et `content` ; `content` est renseigné après le rendu.

Les événements de commande exposent `cmd`, une instance de `andy87\yii2\file_crafter\components\models\dto\Cmd` :

- `exec` (`string`) : commande après remplacement de marque.
- `output` (`?string`) : `null` avant exécution, sortie de commande après.
- `replaceList` (`array`) : marquez la carte de remplacement pour le schéma.

<span id="yii2-file-crafter-schema"></span>

## Édition et génération de schémas

L'éditeur de schéma accepte les valeurs enum/set sous forme de tableau JSON de chaînes, par exemple `["draft", "published", "owner's"]`. Les listes invalides sont signalées avant d'enregistrer le schéma. Les schémas non valides hérités sont signalés dans l'aperçu au lieu de provoquer une exception.

L'aperçu n'exécute jamais les commandes CLI configurées. Les commandes s'exécutent uniquement pour une soumission explicite Générer avec les fichiers sélectionnés. Les noms de fichiers de migration conservent l'horodatage soumis par le formulaire d'aperçu, y compris lorsque la génération a lieu plus tard.

Les importations de bases de données conservent les clés primaires et étrangères, les actions référentielles, les index, l'échelle décimale, l'auto-incrémentation, les indicateurs non signés et les valeurs par défaut des colonnes dans le schéma mis en cache. Les clés étrangères sont créées avec la table ; les tables référencées doivent déjà exister. Comme pour toutes les migrations générées, examinez le résultat avant de l'appliquer.

<span id="yii2-file-crafter-tests"></span>

## Essais

Les dépendances de développement PHPUnit nécessitent PHP 8.1 ou version ultérieure et les extensions `dom`, `mbstring` et `pdo_sqlite`. Exécutez ces commandes à partir d'un clone de ce dépôt :

```sh
composer update --prefer-stable --prefer-dist
composer test
```

Pour vérifier uniquement le fichier README :

```sh
composer test:docs
```

Les tests de documentation lisent des exemples directement à partir de ce fichier. Ils vérifient la syntaxe PHP, la configuration du générateur, le flux de prévisualisation/génération du Quick Start, le rendu des modèles, les marques, les abonnements aux événements, les ancres de section uniques et les liens internes. Ils n’exécutent pas les commandes CLI spécifiques à l’application documentées et ne demandent pas de sites Web externes.

La suite par défaut utilise des fichiers temporaires et une base de données SQLite en mémoire. Pour activer le test de régression MySQL, fournissez une base de données de test jetable et l'extension `pdo_mysql` :

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

Les tests MySQL créent et suppriment uniquement leurs propres tables nommées de manière aléatoire. Ils vérifient les clés importées, les valeurs décimales, les valeurs par défaut et l'application des contraintes. Les tests du contrôleur Gii couvrent les mutations isolées du générateur, l'aperçu répété, la sélection de migration sur une limite infime et la validation du formulaire d'énumération/ensemble. CI exécute la suite, y compris les vérifications README, sur PHP 8.1, 8.2, 8.4 et 8.5 avec MySQL 8.4, et vérifie la syntaxe PHP 8.0 séparément.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
