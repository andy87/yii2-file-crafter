<?php

namespace andy87\yii2\file_crafter\components\models;

use andy87\yii2\file_crafter\components\Log;
use Yii;
use yii\helpers\Inflector;
use andy87\yii2\file_crafter\components\rules\UniqueSchemaNameValidator;

/**
 * SchemaDto
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #table #info
 */
class SchemaDro extends \yii\base\Model
{
    // Scenarios
    public const SCENARIO_DEFAULT = self::SCENARIO_CREATE;
    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_UPDATE = 'update';
    public const SCENARIO_REMOVE = 'remove';

    public const TABLE_NAME = 'table_name';
    public const CUSTOM_FIELDS = 'custom_fields';
    public const DB_FIELDS = 'db_fields';

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
     * Needle for unique Schema validation
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
     * @var Field[]
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
            [ [self::TABLE_NAME], 'required' ],
            [ [self::TABLE_NAME], 'string', 'max' => 255 ],
            [ [self::TABLE_NAME], 'unique', 'targetClass' => UniqueSchemaNameValidator::class ],
            [ [self::CUSTOM_FIELDS, self::DB_FIELDS], 'safe'],
            [ [self::CUSTOM_FIELDS, self::DB_FIELDS], 'each', 'rule' => ['safe'] ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            self::TABLE_NAME => 'Table name',
            self::CUSTOM_FIELDS => 'Custom fields',
            self::DB_FIELDS => 'Fields database',
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
            $this->{self::TABLE_NAME}
        );
    }

    /**
     * @return string
     */
    public function displayTableName(): string
    {
        return Inflector::id2camel($this->{self::TABLE_NAME}, '_');
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
        return $this->{self::DB_FIELDS};
    }

    /**
     * @param array $generateList
     *
     * @return bool
     */
    public function isPreviewGenerate(array $generateList): bool
    {
        return in_array($this->{self::TABLE_NAME}, $generateList);
    }

    /**
     * Endpoint for get table_name
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->{self::TABLE_NAME};
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->{self::CUSTOM_FIELDS};
    }

    /**
     * Check on coppy
     *
     * @param string $tableName
     *
     * @return bool
     */
    public function itIs(string $tableName): bool
    {
        return $this->table_name === $tableName;
    }
}