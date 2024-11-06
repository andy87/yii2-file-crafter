<?php

namespace andy87\yii2\file_crafter\components\models;

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
            [ [self::TABLE_NAME], 'string', 'max' => 255 ],
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
            $this->getTableName()
        );
    }

    /**
     * @return string
     */
    public function displayTableName(): string
    {
        return Inflector::id2camel($this->getTableName(), '_');
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
}