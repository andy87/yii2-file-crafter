<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Барлық аудармаларда код мысалдары мен интерфейс элементтерінің атаулары ағылшын тілінде сақталған.

Yii2 File Crafter – қайта пайдалануға болатын үлгілерден және аталған схемалардан файлдарды жасауға арналған Gii генераторы.

## Мазмұны

- [Орнату](#yii2-file-crafter-setup)
- [Конфигурация және жылдам бастау](#yii2-file-crafter-config)
- [Миграциялар](#yii2-file-crafter-migrations)
- [Параметрлер мен шаблондар](#yii2-file-crafter-using)
- [Схеманы өңдеу және құру](#yii2-file-crafter-schema)
- [Тесттер](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Орнату

Талаптар: PHP 8.0 немесе одан жаңа нұсқасы, Yii 2 қолданбасы және `yiisoft/yii2-gii`. File Crafter және Gii қолданбаларын әзірлеуге тәуелділік ретінде орнатыңыз:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Жергілікті Composer орнату үшін `composer`-ді `php composer.phar`-мен ауыстырыңыз. Немесе, осы жазбаларды қолданбаның бар `composer.json` ішіне біріктіріңіз:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Содан кейін іске қосыңыз:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii қолданбада орнатылуы керек: Composer тәуелділік бумаларының `require-dev` тәуелділіктерін орнатпайды. [Composer құжаттамасы](https://getcomposer.org/doc/04-schema.md#require-dev) және [Gii орнату нұсқаулығы](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation) қараңыз.

<span id="yii2-file-crafter-config"></span>

## Конфигурация және жылдам бастау

Мысалдар пайдаланады `$config` қолданбаның конфигурация массивіне арналған. а Basic қолданбаның ішіндегі ең аз конфигурацияны қосыңыз `if (YII_ENV_DEV)` блоктау `config/web.php`, бұрын `return $config`. а Advanced қолданбасы үшін бірдей жазбаларды қызмет көрсететін қолданбаның әзірлеу конфигурациясына біріктіріңіз Gii, мысалы `backend/config/main-local.php`. Сақтау Gii жылы `bootstrap` егер қолданба оны қосқан болса ғана бір рет.

Ең аз конфигурация (көшірусіз қызмет файлын жасайды):

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

Қолданбаның негізгі каталогында `templates/file-crafter/service.tpl` жасаңыз:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Бағдарлама үшін хост пен жазба сценарий жолын реттей отырып, `http://localhost/index.php?r=gii/fileCrafter` ашыңыз.
2. `Product Items` ішіне **Schema name** енгізіп, **Create** түймесін басыңыз. Бұл үлгі үшін дерекқор атрибуттарын бос қалдыруға болады.
3. `default` үлгі тобын және сақталған схеманы таңдап, **Preview** түймесін басыңыз.
4. Ұсынылған `services/ProductItemsService.php` тексеріп, оны таңдап алып, **Generate** түймесін басыңыз.

Алынған файлда мыналар бар:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` таңдалған қолданбаның негізгі каталогына сілтеме жасайды. `@backend` және `@frontend` сияқты бүркеншік аттар Advanced қолданбасын немесе анық бүркеншік ат конфигурациясын қажет етеді; Жылдам бастау оларға байланысты емес.

Келесі балама конфигурация әрбір File Crafter опциясын көрсетеді. Топты таңдамас бұрын сілтеме жасалған үлгілерді жасаңыз. `commands` және `eventHandler` опциялары төменде түсіндіріледі.

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

## Миграциялар

Егер `migration` `false` болмаса, әрбір таңдалған схема үшін кестені жасау миграциясы жасалады. Оны бар кестеге қолдану қатені тудырады. Бар кесте және оның деректері сақталады. Қолданыстағы кестелерге өзгертулер Yii бағанының және индексінің әрекеттері арқылы анық миграцияны талап етеді. Жасалған миграциялар автоматты түрде қолданылмайды.

Толық конфигурацияда көрсетілген `migration` параметрлері әдепкі болып табылады:

- `root`: Yii бүркеншік аттары арқылы шешілетін шығыс каталогы.
- `fileName`: жұрнақ үлгісі; `%s` схеманың кесте атауымен ауыстырылды. Тасымалдау уақыт белгісі префиксі және `.php` кеңейтімі автоматты түрде қосылады.
- `template`: PHP үлгісі көшіруді көрсету үшін пайдаланылады.

Төмендегі барлық опция мысалдары жоғарыдағы ең аз конфигурацияны өзгертеді. Тасымалдауды өшіру үшін:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Параметрлер мен шаблондар

### Схемалармен жұмыс

**Create** көмегімен схеманы жасаңыз. Сақталған схеманы өзгерту немесе атын өзгерту үшін өңдеу белгішесін таңдаңыз және `canDelete` қосылған кезде жою үшін жою түймесін пайдаланыңыз. Схема атауы кіші әріптегі кесте атауына түрлендіріледі: бос орындар астын сызуларға айналады және ASCII әріптерінен, сандардан, астын сызулардан және бос орындардан басқа таңбалар жойылады. Сақталған схемалар конфигурацияланған кэш каталогындағы JSON файлдары болып табылады; қолданбаны жылжытқанда немесе оның жұмыс уақытын тазартқанда сол файлдарды сақтаңыз.

Панель бірнеше схемаларды таңдауды және барлығын бірден таңдауды қолдайды. Бос схема таңдау генератордың барлық қол жетімді схемаларды өңдеуіне әкеледі. Алдын ала қарау ұсынылған файлдарды көрсетеді; Жасау таңдалған файлдарды жазады. Жетіспейтін бастапқы үлгі өткізіліп жіберілді, сондықтан күтілетін файл жоқ болса, бастапқы жолды тексеріңіз.

### Деректер базасының өрістері және импорттары

Схема өңдегішінде өрістерді қосыңыз, жойыңыз және ретін өзгертіңіз. Әрбір өрістің аты, түсініктемесі, түрі, өлшемі және `FK`, `UN` және `NN` жалаулары бар. `UN` бірегей және `NN` нөл емес дегенді білдіреді. `FK` жалауы ғана сыртқы кілт шектеуін анықтамайды; сілтеме жасалған кесте мен бағандар схеманың сыртқы кілт метадеректерінде болуы керек. Өріс атаулары түр мен жалаушаларды ұсына алады, оларды қарап шығу керек.

Өріс түрін таңдау құралы ұсынады `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` және `set`. Дерекқорды қолдау түрі мен драйверіне байланысты өзгереді. Регрессия жинағы SQLite және MySQL жаттығуларын орындайды; ол әрбір дерекқордағы әрбір түрге қолдау көрсетпейді.

`parseDataBase` автоматты толтыру үшін кесте атауларын қоса алады немесе `fakeCache` көмегімен дерекқордан алынған схемаларды көрсете алады. Соңғылары JSON кэш файлдарын жасамай көрсетіледі және оларды панель арқылы жою мүмкін емес. Дерекқорды автотолтыру үшін `autoCompleteStatus` қосулы болуы керек.

### Тасымалдауларды қолдану және теңшеу

Жасалған миграциялар қолданбаның Yii миграция пәрмендері арқылы қаралып, қолданылуы керек. Жасалған `safeDown()` жасалған кестені жояды; миграцияны кері қайтармас бұрын деректердің жоғалу әсерін қарап шығыңыз. Теңшелетін миграция үлгісі схема және генератор нысандарымен бірге `{{migrationClass}}` және `{{tableName}}` пайдалана алады. Импортталған бастапқы кілттер, сыртқы кілттер және индекстер схема метадеректерінде сақталады; жеке өріс жалаушалары сілтеме жасалған кестені немесе бағандарды бермейді.

Пәрмен нәтижесі шығыс және `resultCode` қамтиды. Нөлдік емес пәрменнің шығу коды хабарланады, бірақ конфигурацияланған үлгілердің жасалуын өздігінен тоқтатпайды.

- [Белгілер](#yii2-file-crafter-using-Marks)
- [Кэш](#yii2-file-crafter-using-Cache)
- [Дереккөз](#yii2-file-crafter-using-Source)
- [Үлгілер](#yii2-file-crafter-using-Templates)
- [Теңшелетін өрістер](#yii2-file-crafter-using-CustomFields)
- [Автотолтыру күйі](#yii2-file-crafter-using-autoCompleteStatus)
- [Автотолтыру тізімі](#yii2-file-crafter-using-autoCompleteList)
- [Алдын ала қарау күйі](#yii2-file-crafter-using-previewStatus)
- [Жоюға болады](#yii2-file-crafter-using-canDelete)
- [Мәліметтер базасын талдау](#yii2-file-crafter-using-parseDataBase)
- [Командалар](#yii2-file-crafter-using-Commands)
- [Оқиғалар](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Белгілер

Белгілер үлгі мазмұнында, жолдар мен пәрмендерде ауыстырылады. Төменде көрсетілген дәл емлесі бар қос жақшаларды пайдаланыңыз. `Product Items` деп аталатын схема үшін:

| Белгілеу | Нәтиже |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Бас әріптер мен кіші әріптер астыңғы сызықтарды қоса алғанда, қалыпты кесте атауын пайдаланады. Теңшелетін өрістер бірдей синтаксисті пайдаланады, мысалы `{{singular}}`; [Теңшелетін өрістер](#yii2-file-crafter-using-CustomFields) қараңыз. Белгісіз белгілер өзгеріссіз қалдырылады, сондықтан алдын ала қарауда файл атауларын тексеріңіз.

<span id="yii2-file-crafter-using-Cache"></span>

## Кэш

Схемалар JSON файлдары ретінде сақталады. Әдепкі кэш параметрлері:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Дереккөз

Әдепкі көз параметрлері (Жылдам бастау `dir`-ді қайта анықтайды):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Үлгілер

`templates` топ атауларын бастапқы үлгі жолдары мен шығыс жолдарының массивтеріне салыстырады:

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

Алдын ала қарау алдында Gii ішінде қажетті топты таңдаңыз.

- Қатысты бастапқы жолдар мына жерден басталады `source['dir']`; Yii бүркеншік атымен басталатын жолдар сол бүркеншік атты пайдаланады. Кеңейтімсіз бастапқы жолды қабылдайды `source['ext']`, әдепкі бойынша `.tpl`.
- Салыстырмалы шығыс жолдары `@app` басталады. Қажетті кеңейтімді нақты көрсетіңіз; кәдімгі үлгі шығыс жолдарына ешқандай кеңейтім қосылмайды.
- Екі жолда [Белгілер](#yii2-file-crafter-using-Marks) болуы мүмкін.

Кәдімгі `.tpl` файлы мәтін ретінде оқылады, содан кейін оның белгілері ауыстырылады. Оның ішіндегі PHP жылдам бастаудағы сияқты шығысқа көшіріледі. PHP үлгілері `yii\web\View::renderFile` арқылы көрсетіледі және `$schema` және `$generator` алады; көрсетуден кейін белгіні ауыстыру. Ағымдағы енгізу бастапқы жолда `.php` болғанда PHP көрсетуді таңдайды, сондықтан мәтін үлгілерін атауларында `.php` бар каталогтардан тыс сақтаңыз.

Мысалы, `templates/file-crafter/view.php` мыналарды қамтуы мүмкін:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

`Product Items` үшін шығыс:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Теңшелетін өрістер

Пернелер реттелетін белгілерді анықтайды; мәндер схема өңдегішіндегі белгілерді анықтайды:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Схема үшін `Product Items`, енгізіңіз `product` жылы **Singular name** және `products` жылы **Plural name**. Мәтін үлгісі мына мәндерді пайдалана алады:

<!-- example: custom-template -->
```text
Item: {{singular}}
List: {{plural}}
```

Нәтиже:

<!-- example: custom-result -->
```text
Item: product
List: products
```

<span id="yii2-file-crafter-using-autoCompleteStatus"></span>

## Автотолтыру күйі

`autoCompleteStatus` **Schema name** үшін кірістірілген, реттелетін және дерекқор ұсыныстарын қосады. Әдепкі: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Автотолтыру тізімі

`autoCompleteList`, `autoCompleteStatus` `true` болғанда, реттелетін схема атауы ұсыныстарын береді. Әдепкі: бос массив.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Алдын ала қарау күйі

`previewStatus` белгіше меңзерінде көрсетілген схема мазмұнын алдын ала қарауды қосады. Әдепкі: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Жоюға болады

`canDelete` панельден схеманы жоюды басқарады. Әдепкі: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Мәліметтер базасын талдау

`parseDataBase` кесте атауларын ұсыныстарға (`autocomplete`) және/немесе дерекқордан алынған схемаларды панельге (`fakeCache`) импорттайды. Әдепкі: бос массив. Бұл опциялар конфигурацияланған `db` қолданба компонентін қажет етеді.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Командалар

`commands` - [Белгілер](#yii2-file-crafter-using-Marks) ауыстырылатын CLI пәрмендерінің тізімі. Әдепкі: бос массив. Пәрмендер әрбір таңдалған схема үшін таңдалған файлдармен нақты **Generate** жіберуде оның конфигурацияланған үлгілерін көрсету алдында орындалады. **Preview** оларды ешқашан орындамайды.

Gii консоль модулі конфигурацияланған қолданба, бар кесте және `common\models` аттар кеңістігі үшін бұл пәрмен ActiveRecord үлгісін жасайды:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Пәрмендер PHP процесінің жұмыс каталогында орындалады. PHP орындалатын файлын, консольдық енгізу сценарийінің жолын және қолданба үшін аттар кеңістігін реттеңіз. Пәрмендер файлдарды Gii ішінде таңдалған файлдардан тәуелсіз өзгерте алады.

<span id="yii2-file-crafter-using-Events"></span>

## Оқиғалар

`eventHandler` генераторға Yii әрекетін қосады. Әдепкі: `null`. Қолданбада `components/behaviors/FileCrafterBehavior.php` жасаңыз:

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

Ең аз конфигурацияда әрекетті қосыңыз:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

Advanced қолданбасында әрекеттің аттар кеңістігі мен конфигурациясын оның орнына сәйкестендіру үшін реттеңіз, мысалы, `backend\components\behaviors`. `events()` картасы қажет: өңдеуші әдіс атаулары оқиғаларға жазылмайды.

Барлық оқиғалар `options`-ді көрсетеді. Жасалмас бұрын оқиға `listSchemaDto` және шешілген `generateList` бар; өңдеушілер таңдалған кесте атауларын өзгерте алады. Жасалғаннан кейін оқиға `files` (`yii\gii\CodeFile[]`) қамтиды. Рендеринг оқиғалары `schema`, `sourcePath`, `generatePath`, `replaceList` және `content`; `content` көрсетуден кейін толтырылады.

Пәрмен оқиғалары `cmd`, `andy87\yii2\file_crafter\components\models\dto\Cmd` данасын көрсетеді:

- `exec` (`string`): белгіні ауыстырғаннан кейін пәрмен.
- `output` (`?string`): `null` орындау алдында, пәрменді кейін шығару.
- `replaceList` (`array`): схема үшін ауыстыру картасын белгілеңіз.

<span id="yii2-file-crafter-schema"></span>

## Схеманы өңдеу және құру

Схема өңдегіші enum/жинақ мәндерін жолдардың JSON массиві ретінде қабылдайды, мысалы, `["draft", "published", "owner's"]`. Жарамсыз тізімдер схеманы сақтау алдында хабарланады. Бұрынғы жарамсыз схемалар ерекше жағдайды тудырудың орнына алдын ала қарауда хабарланады.

Алдын ала қарау ешқашан конфигурацияланған CLI пәрмендерін іске қоспайды. Пәрмендер тек таңдалған файлдармен нақты Жасау жіберу үшін орындалады. Тасымалдау файл атаулары алдын ала қарау пішіні арқылы жіберілген уақыт белгісін сақтайды, соның ішінде Жасау кейінгі минутта орын алады.

Дерекқор импорты кэштелген схемада бастапқы және сыртқы кілттерді, анықтамалық әрекеттерді, индекстерді, ондық шкалаларды, автоматты өсуді, қолтаңбасыз жалаушаларды және бағанның әдепкі мәндерін сақтайды. Сыртқы кілттер кестемен бірге жасалады; сілтеме жасалған кестелер бұрыннан бар болуы керек. Барлық жасалған миграциялар сияқты, оны қолданбас бұрын нәтижені қарап шығыңыз.

<span id="yii2-file-crafter-tests"></span>

## Тесттер

PHPUnit әзірлеу тәуелділіктері PHP 8.1 немесе одан жаңа нұсқасын және `dom`, `mbstring` және `pdo_sqlite` кеңейтімдерін қажет етеді. Осы репозиторийдің клонынан мына пәрмендерді іске қосыңыз:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

Тек README тексеру үшін:

```sh
composer test:docs
```

Құжаттама сынақтары мысалдарды тікелей осы файлдан оқиды. Олар PHP синтаксисін, генератор конфигурациясын, Жылдам іске қосудың алдын ала қарау/генерациялау ағынын, үлгіні көрсетуді, белгілерді, оқиға жазылымдарын, бірегей бөлім анкерлерін және ішкі сілтемелерді тексереді. Олар құжатталған қолданбаға арналған CLI пәрмендерін орындамайды немесе сыртқы веб-сайттарды сұрамайды.

Әдепкі жинақ уақытша файлдарды және жадтағы SQLite дерекқорын пайдаланады. MySQL регрессия сынағын қосу үшін бір реттік сынақ дерекқорын және `pdo_mysql` кеңейтімін қамтамасыз етіңіз:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

MySQL сынақтары тек өздерінің кездейсоқ аталған кестелерін жасайды және жояды. Олар импортталған кілттерді, ондық мәндерді, әдепкі мәндерді және шектеулердің орындалуын тексереді. Gii контроллері сынақтары оқшауланған генератор мутацияларын, қайталанатын Алдын ала қарауды, минуттық шекара арқылы миграцияны таңдауды және нөмір/жинақ пішінін тексеруді қамтиды. CI MySQL 8.4 көмегімен PHP 8.1, 8.2, 8.4 және 8.5 нұсқаларында README тексерулерін қоса, пакетті іске қосады және PHP 8.0 синтаксисін бөлек тексереді.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
