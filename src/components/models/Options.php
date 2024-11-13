<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\models;

use yii\base\Model;
use andy87\yii2\file_crafter\components\core\CoreGenerator;

/**
 *
 */
class Options extends Model
{
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

    /** @var array  */
    public array $templates = [];



    /** @return array */
    public function rules(): array
    {
        return [
            [['templates'], 'required'],
            [['eventHandler'], 'string'],
            [['eventHandler'], 'trim'],
            [['autoCompleteStatus', 'previewStatus' ], 'boolean'],
            [['cache', 'source', 'commands', 'custom_fields', 'autoCompleteList', 'templates', 'parseDataBase'], 'each', 'rule' => ['array']],
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
}