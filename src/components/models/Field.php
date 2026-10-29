<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\models;

use yii\base\Model;

/**
 * Class DbField
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #db #field
 */
class Field extends Model
{
    public const NAME = 'name';
    public const COMMENT = 'comment';
    public const TYPE = 'type';
    public const SIZE = 'size';
    public const VALUES = 'values';
    public const FOREIGN_KEYS = 'foreignKeys';
    public const UNIQUE = 'unique';
    public const NOT_NULL = 'notNull';


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



    public string $name;
    public string $comment;
    public string $type;
    public ?int $size;
    public bool $foreignKeys;
    public bool $unique;

    public bool $notNull;

    /** @var string[] Allowed enum/set values, preserved as strings in cached schemas. */
    public array $values = [];

    /** @var ?int Number of fractional digits in a decimal column. */
    public ?int $scale = null;

    /** @var bool Whether the database generates successive numeric values. */
    public bool $autoIncrement = false;

    /** @var bool Whether a numeric column excludes negative values. */
    public bool $unsigned = false;

    /** @var mixed Literal column default, kept separate from executable SQL expressions. */
    public mixed $defaultValue = null;

    /** @var ?string Database default expression, such as CURRENT_TIMESTAMP. */
    public ?string $defaultExpression = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [[self::NAME, self::TYPE], 'required'],
            [[self::NAME, self::TYPE, self::COMMENT], 'string'],
            [[self::SIZE], 'integer'],
            [[self::FOREIGN_KEYS, self::UNIQUE, self::NOT_NULL], 'boolean'],
        ];
    }
}
