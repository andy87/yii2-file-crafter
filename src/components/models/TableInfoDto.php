<?php

namespace andy87\yii2\dnk_file_crafter\components\models;

use Yii;
use yii\helpers\Inflector;
use andy87\yii2\dnk_file_crafter\components\models\core\BaseModel;
use andy87\yii2\dnk_file_crafter\components\rules\UniqueTableNameValidator;

/**
 * TableInfoDto
 *
 * @package andy87\yii2\dnk_file_crafter\models
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
     * @return bool
     */
    public function save(): bool
    {
        $params = $this->attributes;

        $params[self::ATTR_TABLE_NAME] = strtolower(str_replace([' ','-'], '_', $params[self::ATTR_TABLE_NAME]));

        $fileName =  $this->cacheParams['dir'] . "/". $params[self::ATTR_TABLE_NAME]  . $this->cacheParams['ext'];

        foreach ($this->db_fields as $index => $dbField)
        {
            if ($dbField[DbFieldDto::ATTR_FOREIGN_KEYS] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_FOREIGN_KEYS] = 'checked';
            }
            if ($dbField[DbFieldDto::ATTR_UNIQUE] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_UNIQUE] = 'checked';
            }
            if ($dbField[DbFieldDto::ATTR_NOT_NULL] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_NOT_NULL] = 'checked';
            }
        }

        unset($params['scenario']);

        $content = json_encode( $params, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

        $update = Yii::$app->request->get(self::SCENARIO_UPDATE);

        if ( $update && $update !== $params[self::ATTR_TABLE_NAME] ) {
            $this->removeItem($update);
        }

        return file_put_contents( Yii::getAlias($fileName), $content );
    }

    /**
     * @param string $item
     *
     * @return void
     */
    public function removeItem(string $item): void
    {
        $itemPath =  $this->cacheParams['dir'] . "/$item" . $this->cacheParams['ext'];

        $itemPath = Yii::getAlias($itemPath);

        if ( file_exists($itemPath)) unlink($itemPath);
    }

    /**
     * @return mixed
     */
    public function getCustomFields(): mixed
    {
        return $this->{self::ATTR_CUSTOM_FIELDS};
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