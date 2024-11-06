<?php

namespace andy87\yii2\file_crafter\components\models;

use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use andy87\yii2\file_crafter\components\rules\UniqueSchemaNameValidator;

/**
 * SchemaDto
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #table #info
 */
class Schema extends Model
{
    // Scenarios
    public const SCENARIO_DEFAULT = self::SCENARIO_CREATE;
    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_UPDATE = 'update';
    public const SCENARIO_REMOVE = 'remove';

    public const NAME = 'name';
    public const TABLE_NAME = 'table_name';
    public const CUSTOM_FIELDS = 'custom_fields';
    public const DB_FIELDS = 'db_fields';



    /**
     * @var string
     */
    public string $scenario = self::SCENARIO_DEFAULT;

    /**
     * @var string
     */
    public string $name = '';

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
     * @return array
     */
    public function rules(): array
    {
        return [
            [ [self::TABLE_NAME], 'required' ],
            [ [self::TABLE_NAME,self::NAME], 'string', 'max' => 255 ],
            //[ [self::TABLE_NAME], 'unique', 'targetClass' => UniqueSchemaNameValidator::class ],
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
            self::TABLE_NAME => 'Schema name',
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
            $this->getTableName()
        );
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
    public function getDbFields(): array
    {
        return $this->db_fields;
    }

    /**
     * @param array $generateList
     *
     * @return bool
     */
    public function isPreviewGenerate(array $generateList): bool
    {
        return in_array($this->getTableName(), $generateList);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Endpoint for get table_name
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->custom_fields;
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


    /**
     * Save schema to cache file
     *
     * @param string $fileName
     *
     * @return bool
     */
    public function save(string $fileName): bool
    {
        $params = $this->attributes;

        foreach ($this->db_fields as $index => $dbField)
        {
            if ($dbField[Field::FOREIGN_KEYS] ?? false) $params[Schema::DB_FIELDS][$index][Field::FOREIGN_KEYS] = 'checked';

            if ($dbField[Field::UNIQUE] ?? false) $params[Schema::DB_FIELDS][$index][Field::UNIQUE] = 'checked';

            if ($dbField[Field::NOT_NULL] ?? false) $params[Schema::DB_FIELDS][$index][Field::NOT_NULL] = 'checked';
        }

        unset($params['scenario']);

        $content = json_encode( $params, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

        return (bool) file_put_contents( Yii::getAlias($fileName), $content );
    }

    /**
     * @return void
     */
    public function prepareNaming(): void
    {
        $this->name = trim($this->name);

        $table_name = preg_replace('/[^a-zA-Z_]/', '', $this->name);

        $this->table_name = strtolower($table_name);
    }

}