<?php

namespace andy87\yii2\file_crafter\components\models;

use Yii;
use yii\helpers\Inflector;
use andy87\yii2\file_crafter\components\models\core\BaseModel;
use andy87\yii2\file_crafter\components\rules\UniqueTableNameValidator;

/**
 * TableInfoDto
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #table #info
 */
class TableInfoDto extends BaseModel
{
    // Scenarios
    public const SCENARIO_DEFAULT = self::SCENARIO_CREATE;
    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_UPDATE = 'update';
    public const SCENARIO_REMOVE = 'remove';

    public const ATTR_TABLE_NAME = 'table_name';
    public const ATTR_CUSTOM_FIELDS = 'custom_fields';
    public const ATTR_DB_FIELDS = 'db_fields';

    /**
     * @var array
     */
    public const TYPES = [
        'string' => 'string',
        'int' => 'int',
        'boolean' => 'boolean',
        'text' => 'text',
        'timestamp' => 'timestamp',
        'datetime' => 'datetime',
        'date' => 'date',
        'time' => 'time',
        'json' => 'json',
        'float' => 'float',
        'double' => 'double',
        'decimal' => 'decimal',
        'jsonb' => 'jsonb',
        'binary' => 'binary',
        'money' => 'money',
        'smallint' => 'smallint',
        'bigint' => 'bigint',
        'char' => 'char',
        'varchar' => 'varchar',
        'tinyint' => 'tinyint',
        'enum' => 'enum',
        'set' => 'set',
    ];


    /**
     * @var string
     */
    public string $scenario = self::SCENARIO_DEFAULT;

    /**
     * Needle for unique table name validation
     *
     * @var array $cacheParams
     */
    private array $cacheParams;

    /**
     * @var string
     */
    public string $table_name = '';

    /**
     * Custom fields, setup on config:
     * ```
     *      $config['modules']['gii'] = [
     *          'class' => yii\gii\Module::class,
     *          'generators' => [
     *              'fileCrafter' => [
     *                  'class' => Crafter::class,
     *                  'params' => [
     *                      'custom_fields' => [
     *                          'key_1' => 'label #1',
     *                          'keyTwo' => 'header 2',
     *                      ],
     *                  ],
     *             ],
     *          ]
     *      ];
     * ```
     * use on template:
     * ```
     *
     * <?= $generator->custom_fields['key_1']; ?>
     *
     * ```
     * @var array
     */
    public array $custom_fields = [];

    /**
     * @var DbFieldDto[]
     */
    public array $db_fields = [];



    /**
     * @param array $cacheParams
     * @param array $config
     */
    public function __construct( array $cacheParams, array $config = [] )
    {
        $this->cacheParams = $cacheParams;

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [ [self::ATTR_TABLE_NAME], 'required' ],
            [ [self::ATTR_TABLE_NAME], 'string', 'max' => 255 ],
            [ [self::ATTR_TABLE_NAME], 'unique', 'targetClass' => UniqueTableNameValidator::class ],
            [ [self::ATTR_CUSTOM_FIELDS, self::ATTR_DB_FIELDS], 'safe'],
            [ [self::ATTR_CUSTOM_FIELDS, self::ATTR_DB_FIELDS], 'each', 'rule' => ['safe'] ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            self::ATTR_TABLE_NAME => 'Table name',
            self::ATTR_CUSTOM_FIELDS => 'Custom fields',
            self::ATTR_DB_FIELDS => 'Fields database',
        ];
    }

    /**
     * @return string
     */
    public function getUpdateHref(): string
    {
        return sprintf(
            '?%s=%s',
            self::SCENARIO_UPDATE,
            $this->{self::ATTR_TABLE_NAME}
        );
    }

    /**
     * @return string
     */
    public function displayTableName(): string
    {
        return Inflector::id2camel($this->{self::ATTR_TABLE_NAME}, '_');
    }

    /**
     * @return bool
     */
    public function isCreate(): bool
    {
        return $this->scenario === self::SCENARIO_CREATE;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->cacheParams;
    }

    /**
     * @return mixed
     */
    public function getDbFields(): mixed
    {
        return $this->{self::ATTR_DB_FIELDS};
    }

    /**
     * @param array $generateList
     *
     * @return bool
     */
    public function isPreviewGenerate(array $generateList): bool
    {
        return in_array($this->{self::ATTR_TABLE_NAME}, $generateList);
    }
}