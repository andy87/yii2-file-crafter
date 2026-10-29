<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\models;

use yii\base\Model;
use andy87\yii2\file_crafter\components\core\CoreGenerator;

/**
 *
 */
class Options extends Model
{
    private const DEFAULT = [
        'migration' => [
            'root' => '@app/migrations',
            'fileName' => '_file_crafter_migration_%s',
            'template' => '@vendor/andy87/yii2-file-crafter/src/components/templates/migration.php',
        ],
    ];
    /** @var array  */
    public array $cache = [
        'dir' => CoreGenerator::DEFAULT_RESOURCES_DIR . '/cache',
        'ext' => '.json'
    ];

    /** @var array  */
    public array $source = [
        'dir' => CoreGenerator::DEFAULT_RESOURCES_DIR . '/templates/source',
        'ext' => '.tpl'
    ];

    /** @var array  */
    public array $commands = [];

    /** @var ?string  */
    public ?string $eventHandler = null;

    /** @var array  */
    public array $custom_fields = [];

    /** @var bool  */
    public bool $autoCompleteStatus = false;

    /** @var array  */
    public array $autoCompleteList = [];

    /** @var bool  */
    public bool $previewStatus = true;

    /** @var bool  */
    public bool $canDelete = true;

    /** @var array  */
    public array $parseDataBase = [];

    /** @var array|false Migration settings, or false to disable generation. */
    public array|false $migration = [];

    /** @var array  */
    public array $templates = [
        'migration' => 'migration',
    ];


    public function init(): void
    {
        parent::init();

        $this->prepareMigration();
    }

    /** @return array */
    public function rules(): array
    {
        return [
            [['templates'], 'required'],
            [['eventHandler'], 'string'],
            [['eventHandler'], 'trim'],
            [['autoCompleteStatus', 'previewStatus', 'canDelete'], 'boolean'],
            [['cache', 'source', 'templates','custom_fields'], 'each', 'rule' => ['safe']],
            [['commands', 'autoCompleteList', 'parseDataBase'], 'each', 'rule' => ['string']],
            ['migration', 'prepareMigration']
        ];
    }

    /** @return array */
    public function attributeLabels(): array
    {
        return [
            'cache' => 'Cache',
            'source' => 'Source',
            'commands' => 'Commands',
            'eventHandler' => 'Event Handler',
            'custom_fields' => 'Custom Fields',
            'autoCompleteStatus' => 'Autocomplete Status',
            'autoCompleteList' => 'Autocomplete List',
            'previewStatus' => 'Preview Status',
            'parseDataBase' => 'Parse Data Base',
            'templates' => 'Templates',
        ];
    }

    /**
     * Подготовка настроек миграции по умолчанию.
     *
     * @return void
     */
    public function prepareMigration(): void
    {
        if ($this->migration === false) return;

        foreach (self::DEFAULT['migration'] as $key => $defaultValue) {
            if (isset($this->migration[$key])) {
                continue;
            }
            $this->migration[$key] = $defaultValue;
        }

        $this->migration['root'] = str_replace('\\', '/', $this->migration['root']);
        $this->migration['root'] = rtrim($this->migration['root'], '/\\');
    }
}
