<?php

namespace andy87\yii2\dnk_file_crafter\components\models;

use andy87\yii2\dnk_file_crafter\components\models\core\BaseModel;
use andy87\yii2\dnk_file_crafter\components\rules\UniqueTableNameValidator;
use Yii;

/**
 * Class TableInfo
 *
 * @package andy87\yii2\dnk_file_crafter\models
 *
 * @tag: #model #table #info
 */
class TableInfoDto extends BaseModel
{
    /**
     * Needle for unique table name validation
     *
     * @var array
     */
    private array $paramsCache;


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
    public array $listCustomField = [];

    /**
     * @var DbFieldDto[]
     */
    public array $listDbFields = [];




    /**
     * @param array $paramsCache
     *
     * @param array $config
     */
    public function __construct( array $paramsCache, array $config = [] )
    {
        $this->paramsCache = $paramsCache;

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
                'paramsCache' => $this->paramsCache,
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
}