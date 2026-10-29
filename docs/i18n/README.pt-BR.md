<h1 align="center">Yii2 File Crafter</h1>

**Languages / Языки:** [English](../../README.md) | [Русский](README.ru.md) | [简体中文](README.zh-CN.md) | [Português (Brasil)](README.pt-BR.md) | [Español](README.es.md) | [日本語](README.ja.md) | [Қазақша](README.kk.md) | [Français](README.fr.md) | [Deutsch](README.de.md)

Os exemplos de código e os rótulos da interface permanecem em inglês em todas as traduções.

Yii2 File Crafter é um gerador Gii para criar arquivos a partir de modelos reutilizáveis ​​e esquemas nomeados.

## Conteúdo

- [Configurar](#yii2-file-crafter-setup)
- [Configuração e início rápido](#yii2-file-crafter-config)
- [Migrações](#yii2-file-crafter-migrations)
- [Opções e modelos](#yii2-file-crafter-using)
- [Edição e geração de esquema](#yii2-file-crafter-schema)
- [Testes](#yii2-file-crafter-tests)

<span id="yii2-file-crafter-setup"></span>

## Configurar

Requisitos: PHP 8.0 ou mais recente, uma aplicação Yii 2 e `yiisoft/yii2-gii`. Instale File Crafter e Gii como dependências de desenvolvimento no aplicativo:

```sh
composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:^2.2.7"
```

Para uma instalação Composer local, substitua `composer` por `php composer.phar`. Como alternativa, mescle essas entradas no `composer.json` existente do aplicativo:

<!-- example: composer-config -->
```json
{
    "require-dev": {
        "andy87/yii2-file-crafter": "dev-master",
        "yiisoft/yii2-gii": "^2.2.7"
    }
}
```

Então execute:

```sh
composer update andy87/yii2-file-crafter yiisoft/yii2-gii
```

Gii deve ser instalado no aplicativo: Composer não instala as dependências `require-dev` de pacotes de dependência. Consulte [Documentação do Composer](https://getcomposer.org/doc/04-schema.md#require-dev) e [Guia de instalação do Gii](https://www.yiiframework.com/extension/yiisoft/yii2-gii/doc/guide/2.2/en/installation).

<span id="yii2-file-crafter-config"></span>

## Configuração e início rápido

Os exemplos usam `$config` para a matriz de configuração do aplicativo. Em uma aplicação Basic, adicione a configuração mínima dentro do bloco `if (YII_ENV_DEV)` existente em `config/web.php`, antes de `return $config`. Em um aplicativo Advanced, mescle as mesmas entradas na configuração de desenvolvimento do aplicativo que atende Gii, por exemplo `backend/config/main-local.php`. Mantenha Gii em `bootstrap` apenas uma vez se o aplicativo já o ativar.

Configuração mínima (gera um arquivo de serviço sem migração):

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

Crie `templates/file-crafter/service.tpl` no diretório base do aplicativo:

<!-- example: service-template -->
```text
<?php

namespace app\services;

/** Service for {{PascalCase}} records. */
class {{PascalCase}}Service
{
}
```

1. Abra `http://localhost/index.php?r=gii/fileCrafter`, ajustando o host e o caminho do script de entrada para o aplicativo.
2. Insira `Product Items` em **Schema name** e clique em **Create**. Os atributos do banco de dados podem ser deixados vazios para este modelo.
3. Selecione o grupo de modelos `default` e o esquema salvo e clique em **Preview**.
4. Verifique o `services/ProductItemsService.php` proposto, mantenha-o selecionado e clique em **Generate**.

O arquivo resultante contém:

<!-- example: service-result -->
```php
<?php

namespace app\services;

/** Service for ProductItems records. */
class ProductItemsService
{
}
```

`@app` refere-se ao diretório base do aplicativo selecionado. Aliases como `@backend` e `@frontend` requerem um aplicativo Advanced ou configuração de alias explícita; o Quick Start não depende deles.

A configuração alternativa a seguir mostra todas as opções File Crafter. Crie os modelos referenciados antes de selecionar seu grupo. As opções `commands` e `eventHandler` são explicadas abaixo.

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

## Migrações

A menos que `migration` seja `false`, uma migração de criação de tabela será gerada para cada esquema selecionado. Aplicá-lo a uma tabela existente gera um erro. A tabela existente e seus dados são preservados. Mudanças em tabelas existentes requerem uma migração explícita usando colunas e operações de índice do Yii. As migrações geradas não são aplicadas automaticamente.

As configurações `migration` mostradas na configuração completa são os padrões:

- `root`: diretório de saída, resolvido através de aliases do Yii.
- `fileName`: padrão de sufixo; `%s` é substituído pelo nome da tabela do esquema. Um prefixo de carimbo de data/hora de migração e uma extensão `.php` são adicionados automaticamente.
- `template`: modelo PHP usado para renderizar a migração.

Todos os exemplos de opções abaixo modificam a configuração mínima acima. Para desativar migrações:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['migration'] = false;
```

<span id="yii2-file-crafter-using"></span>

## Opções e modelos

### Trabalhando com esquemas

Crie um esquema com **Create**. Selecione o ícone de edição para alterar ou renomear um esquema salvo e use o botão excluir para removê-lo quando `canDelete` estiver ativado. O nome do esquema é convertido em um nome de tabela em letras minúsculas: os espaços tornam-se sublinhados e os caracteres diferentes de letras ASCII, dígitos, sublinhados e espaços em branco são removidos. Os esquemas salvos são arquivos JSON no diretório de cache configurado; retenha esses arquivos ao mover o aplicativo ou limpar seu tempo de execução.

O painel oferece suporte à seleção de vários esquemas e à seleção de todos de uma vez. Uma seleção de esquema vazia faz com que o gerador processe todos os esquemas disponíveis. A visualização mostra os arquivos propostos; Gerar grava os arquivos selecionados. Um modelo de origem ausente é ignorado; portanto, verifique o caminho de origem se um arquivo esperado estiver ausente.

### Campos e importações do banco de dados

Adicione, remova e reordene campos no editor de esquema. Cada campo possui um nome, comentário, tipo, tamanho e sinalizadores `FK`, `UN` e `NN`. `UN` significa exclusivo e `NN` significa não nulo. O sinalizador `FK` sozinho não define uma restrição de chave estrangeira; a tabela e as colunas referenciadas devem estar presentes nos metadados de chave estrangeira do esquema. Os nomes dos campos podem sugerir um tipo e sinalizadores, que devem ser revisados.

O seletor de tipo de campo oferece `string`, `int`, `boolean`, `text`, `timestamp`, `datetime`, `date`, `time`, `json`, `float`, `double`, `decimal`, `jsonb`, `binary`, `money`, `smallint`, `bigint`, `char`, `varchar`, `tinyint`, `enum` e `set`. O suporte do banco de dados varia de acordo com o tipo e o driver. O conjunto de regressão exercita SQLite e MySQL; ele não estabelece suporte para todos os tipos em todos os bancos de dados.

`parseDataBase` pode adicionar nomes de tabelas para preenchimento automático ou mostrar esquemas derivados de banco de dados com `fakeCache`. Os últimos são exibidos sem a criação de arquivos de cache JSON e não podem ser excluídos por meio do painel. O preenchimento automático do banco de dados requer que `autoCompleteStatus` esteja habilitado.

### Aplicando e customizando migrações

As migrações geradas devem ser revisadas e aplicadas através dos comandos de migração do Yii da aplicação. O `safeDown()` gerado elimina a tabela criada; revise o impacto da perda de dados antes de reverter uma migração. Um modelo de migração customizado pode usar `{{migrationClass}}` e `{{tableName}}` junto com o esquema e os objetos geradores. Chaves primárias, chaves estrangeiras e índices importados são armazenados em metadados de esquema; sinalizadores de campo individuais não fornecem uma tabela ou colunas referenciadas.

O resultado do comando inclui saída e `resultCode`. Um código de saída de comando diferente de zero é relatado, mas por si só não interrompe a geração de modelos configurados.

- [Marcas](#yii2-file-crafter-using-Marks)
- [Cache](#yii2-file-crafter-using-Cache)
- [Fonte](#yii2-file-crafter-using-Source)
- [Modelos](#yii2-file-crafter-using-Templates)
- [Campos personalizados](#yii2-file-crafter-using-CustomFields)
- [Status de preenchimento automático](#yii2-file-crafter-using-autoCompleteStatus)
- [Lista de preenchimento automático](#yii2-file-crafter-using-autoCompleteList)
- [Status de visualização](#yii2-file-crafter-using-previewStatus)
- [Pode excluir](#yii2-file-crafter-using-canDelete)
- [Analisar banco de dados](#yii2-file-crafter-using-parseDataBase)
- [Comandos](#yii2-file-crafter-using-Commands)
- [Eventos](#yii2-file-crafter-using-Events)

<span id="yii2-file-crafter-using-Marks"></span>

## Marcas

As marcas são substituídas no conteúdo, caminhos e comandos do modelo. Use colchetes duplos com a grafia exata mostrada abaixo. Para um esquema denominado `Product Items`:

| Marca | Resultado |
| --- | --- |
| `{{PascalCase}}` | `ProductItems` |
| `{{camelCase}}` | `productItems` |
| `{{snake_case}}` | `product_items` |
| `{{kebab-case}}` | `product-items` |
| `{{UPPERCASE}}` | `PRODUCT_ITEMS` |
| `{{lowercase}}` | `product_items` |

Maiúsculas e minúsculas usam o nome da tabela normalizada, incluindo sublinhados. Os campos personalizados usam a mesma sintaxe, por exemplo `{{singular}}`; consulte [Campos personalizados](#yii2-file-crafter-using-CustomFields). As marcas desconhecidas permanecem inalteradas, portanto verifique os nomes dos arquivos na visualização.

<span id="yii2-file-crafter-using-Cache"></span>

## Cache

Os esquemas são armazenados como arquivos JSON. Configurações de cache padrão:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['cache'] = [
    'dir' => '@app/runtime/yii2-file-crafter/cache',
    'ext' => '.json',
];
```

<span id="yii2-file-crafter-using-Source"></span>

## Fonte

Configurações de fonte padrão (o Quick Start substitui `dir`):

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['source'] = [
    'dir' => '@app/runtime/yii2-file-crafter/templates/source',
    'ext' => '.tpl',
];
```

<span id="yii2-file-crafter-using-Templates"></span>

## Modelos

`templates` mapeia nomes de grupos para matrizes de caminhos de modelo de origem e caminhos de saída:

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

Selecione o grupo necessário em Gii antes da Visualização.

- Os caminhos de origem relativos começam em `source['dir']`; caminhos que começam com um alias do Yii usam esse alias. Um caminho de origem sem extensão recebe `source['ext']`, cujo padrão é `.tpl`.
- Os caminhos de saída relativos começam em `@app`. Especifique explicitamente a extensão desejada; nenhuma extensão é adicionada aos caminhos de saída de modelos comuns.
- Ambos os caminhos podem conter [Marcas](#yii2-file-crafter-using-Marks).

Um arquivo `.tpl` normal é lido como texto e suas marcas são substituídas. O PHP dentro dele é copiado na saída, como no Quick Start. Os templates PHP são renderizados com `yii\web\View::renderFile` e recebem `$schema` e `$generator`; a substituição da marca segue a renderização. A implementação atual seleciona a renderização PHP quando o caminho de origem contém `.php`, portanto, mantenha os modelos de texto fora dos diretórios cujos nomes contenham `.php`.

Por exemplo, `templates/file-crafter/view.php` pode conter:

<!-- example: php-template -->
```php
<?php

/** @var andy87\yii2\file_crafter\components\models\Schema $schema Schema being generated. */
/** @var andy87\yii2\file_crafter\Crafter $generator Active generator. */
echo $schema->getName() . ' from ' . $generator->getName();
```

Para `Product Items`, a saída é:

<!-- example: php-result -->
```text
Product Items from File Crafter
```

<span id="yii2-file-crafter-using-CustomFields"></span>

## Campos personalizados

As chaves definem marcas personalizadas; os valores definem rótulos no editor de esquema:

<!-- example: custom-fields -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['custom_fields'] = [
    'singular' => 'Singular name',
    'plural' => 'Plural name',
];
```

Para o esquema `Product Items`, insira `product` em **Singular name** e `products` em **Plural name**. Um modelo de texto pode usar estes valores:

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

## Status de preenchimento automático

`autoCompleteStatus` permite sugestões integradas, personalizadas e de banco de dados para **Schema name**. Padrão: `false`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteStatus'] = true;
```

<span id="yii2-file-crafter-using-autoCompleteList"></span>

## Lista de preenchimento automático

`autoCompleteList` fornece sugestões de nomes de esquema customizados quando `autoCompleteStatus` é `true`. Padrão: uma matriz vazia.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['autoCompleteList'] = [
    'Product Items',
    'Category Group',
    'User Profile',
];
```

<span id="yii2-file-crafter-using-previewStatus"></span>

## Status de visualização

`previewStatus` permite a visualização do conteúdo do esquema mostrada ao passar o mouse sobre o ícone. Padrão: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['previewStatus'] = true;
```

<span id="yii2-file-crafter-using-canDelete"></span>

## Pode excluir

`canDelete` controla a exclusão do esquema do painel. Padrão: `true`.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['canDelete'] = true;
```

<span id="yii2-file-crafter-using-parseDataBase"></span>

## Analisar banco de dados

`parseDataBase` importa nomes de tabelas em sugestões (`autocomplete`) e/ou esquemas derivados de banco de dados para o painel (`fakeCache`). Padrão: uma matriz vazia. Essas opções requerem um componente de aplicativo `db` configurado.

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['parseDataBase'] = ['autocomplete', 'fakeCache'];
```

<span id="yii2-file-crafter-using-Commands"></span>

## Comandos

`commands` é uma lista de comandos CLI com substituição de [Marcas](#yii2-file-crafter-using-Marks). Padrão: uma matriz vazia. Os comandos são executados para cada esquema selecionado em um envio **Generate** explícito com arquivos selecionados, antes de renderizar seus modelos configurados. **Preview** nunca os executa.

Para uma aplicação com o módulo de console Gii configurado, uma tabela existente e um namespace `common\models`, este comando gera seu modelo ActiveRecord:

```php
$config['modules']['gii']['generators']['fileCrafter']['options']['commands'] = [
    'php yii gii/model --tableName={{snake_case}} --modelClass={{PascalCase}} --ns="common\models" --interactive=0',
];
```

Os comandos são executados no diretório de trabalho do processo PHP. Ajuste o executável do PHP, o caminho do script de entrada do console e o namespace do aplicativo. Os comandos podem modificar arquivos independentemente dos arquivos selecionados em Gii.

<span id="yii2-file-crafter-using-Events"></span>

## Eventos

`eventHandler` anexa um comportamento Yii ao gerador. Padrão: `null`. Crie `components/behaviors/FileCrafterBehavior.php` na aplicação:

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

Habilite o comportamento na configuração mínima:

<!-- example: event-config -->
```php
$config['modules']['gii']['generators']['fileCrafter']['options']['eventHandler'] = app\components\behaviors\FileCrafterBehavior::class;
```

Em um aplicativo Advanced, ajuste o namespace e a configuração do comportamento para corresponder à sua localização, por exemplo, `backend\components\behaviors`. O mapa `events()` é necessário: apenas os nomes dos métodos do manipulador não assinam eventos.

Todos os eventos expõem `options`. Antes da geração, o evento contém `listSchemaDto` e o `generateList` resolvido; manipuladores podem alterar os nomes das tabelas selecionadas. Após a geração, o evento contém `files` (`yii\gii\CodeFile[]`). Os eventos de renderização expõem `schema`, `sourcePath`, `generatePath`, `replaceList` e `content`; `content` é preenchido após a renderização.

Os eventos de comando expõem `cmd`, uma instância de `andy87\yii2\file_crafter\components\models\dto\Cmd`:

- `exec` (`string`): comando após substituição de marca.
- `output` (`?string`): `null` antes da execução, saída do comando depois.
- `replaceList` (`array`): marque o mapa de substituição para o esquema.

<span id="yii2-file-crafter-schema"></span>

## Edição e geração de esquema

O editor de esquema aceita valores enum/set como uma matriz JSON de strings, por exemplo `["draft", "published", "owner's"]`. Listas inválidas são relatadas antes de salvar o esquema. Esquemas inválidos herdados são relatados na Visualização em vez de causar uma exceção.

A visualização nunca executa comandos CLI configurados. Os comandos são executados apenas para um envio explícito de Geração com arquivos selecionados. Os nomes de arquivos de migração retêm o carimbo de data/hora enviado pelo formulário de visualização, inclusive quando a geração ocorre em um minuto posterior.

As importações de banco de dados retêm chaves primárias e estrangeiras, ações referenciais, índices, escala decimal, incremento automático, sinalizadores não assinados e padrões de coluna no esquema em cache. As chaves estrangeiras são criadas com a tabela; as tabelas referenciadas já devem existir. Tal como acontece com todas as migrações geradas, revise o resultado antes de aplicá-lo.

<span id="yii2-file-crafter-tests"></span>

## Testes

As dependências de desenvolvimento do PHPUnit requerem PHP 8.1 ou mais recente e as extensões `dom`, `mbstring` e `pdo_sqlite`. Execute estes comandos a partir de um clone deste repositório:

```sh
composer update --prefer-stable --prefer-dist
composer test
```

Para verificar apenas o README:

```sh
composer test:docs
```

Os testes de documentação leem exemplos diretamente deste arquivo. Eles verificam a sintaxe do PHP, a configuração do gerador, o fluxo de visualização/geração do Quick Start, renderização de modelos, marcas, assinaturas de eventos, âncoras de seção exclusivas e links internos. Eles não executam os comandos CLI documentados específicos do aplicativo nem solicitam sites externos.

O conjunto padrão usa arquivos temporários e um banco de dados SQLite na memória. Para ativar o teste de regressão MySQL, forneça um banco de dados de teste descartável e a extensão `pdo_mysql`:

```sh
FILE_CRAFTER_TEST_MYSQL_DSN='mysql:host=127.0.0.1;port=3306;dbname=file_crafter_test' \
FILE_CRAFTER_TEST_MYSQL_USER=root \
FILE_CRAFTER_TEST_MYSQL_PASSWORD=test-password \
vendor/bin/phpunit --fail-on-warning --fail-on-risky --fail-on-incomplete --fail-on-skipped
```

Os testes do MySQL criam e removem apenas suas próprias tabelas nomeadas aleatoriamente. Eles verificam chaves importadas, valores decimais, padrões e aplicação de restrições. Os testes do controlador Gii cobrem mutações isoladas do gerador, visualização repetida, seleção de migração através de um limite de minuto e validação de formulário enum/set. CI executa o conjunto, incluindo as verificações README, no PHP 8.1, 8.2, 8.4 e 8.5 com MySQL 8.4, e verifica a sintaxe do PHP 8.0 separadamente.

[Packagist](https://packagist.org/packages/andy87/yii2-file-crafter)
