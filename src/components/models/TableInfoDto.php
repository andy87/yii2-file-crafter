<?php

namespace andy87\yii2\dnk_file_crafter\components\models;

use andy87\yii2\dnk_file_crafter\components\models\core\BaseModel;
use andy87\yii2\dnk_file_crafter\components\rules\UniqueTableNameValidator;
use andy87\yii2\dnk_file_crafter\components\services\CacheService;
use Yii;
use yii\caching\Cache;

/**
 * Class TableInfo
 *
 * @package andy87\yii2\dnk_file_crafter\models
 *
 * @tag: #model #table #info
 */
class TableInfoDto extends BaseModel
{
    // Scenarios
    const SCENARIO_DEFAULT = self::SCENARIO_CREATE;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';


    /**
     * @var string
     */
    public string $scenario = self::SCENARIO_DEFAULT;



    /**
     * Needle for unique table name validation
     *
     * @var CacheService
     */
    private CacheService $cacheService;


    /**
     * @var string
     */
    public string $tableName;

    /**
     * Custom fields, setup on config:
     * ```
     *      $config['modules']['gii'] = [
     *          'class' => yii\gii\Module::class,
     *          'generators' => [
     *              'fileCrafter' => [
     *                  'class' => Crafter::class,
     *                      'params' => [
     *                          'custom_fields' => [
     *                              'key_1' => 'label #1',
     *                              'keyTwo' => 'header 2',
     *                          ],
     *                      ],
     *                  ],
     *             ],
     *          ]
     *      ];
     * ```
     * use on template:
     * ```
     *
     * <?= $generator->customFields['key_1']; ?>
     *
     * ```
     * @var array
     */
    public array $customFields = [];

    /**
     * @var DbFieldDto[]
     */
    public array $dbFields = [];




    /**
     * @param CacheService $cacheService
     *
     * @param array $config
     */
    public function __construct( CacheService $cacheService, array $config = [] )
    {
        $this->cacheService = $cacheService;

        parent::__construct($config);
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['tableName'], 'required'],
            [['listCustomField', 'listDbFields'], 'safe'],
            [['tableName'], 'string', 'max' => 255],
            [['tableName'],
                'unique',
                'targetClass' => UniqueTableNameValidator::class,
                'paramsCache' => $this->cacheService->params,
            ],
            [['listCustomField', 'listDbFields'], 'each', 'rule' => ['safe']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'tableName' => 'Table name',
            'listCustomField' => 'Custom fields',
            'listDbFields' => 'DB fields',
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
            $this->tableName
        );
    }

    /**
     * @return string
     */
    public function displayTableName(): string
    {
        return ucfirst( strtolower( str_replace('_', ' ', $this->tableName) ) );
    }

    /**
     * @return bool
     */
    public function isCreate(): bool
    {
        return $this->scenario === self::SCENARIO_CREATE;
    }
}