<?php

namespace andy87\yii2\file_crafter\components\rules;

use yii\validators\UniqueValidator;
use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\services\CacheService;

/**
 * Class UniqueTableNameValidator
 *
 * @package andy87\yii2\file_crafter\components\rules
 *
 * @tag: #validator #unique #table #name
 */
class UniqueSchemaNameValidator extends UniqueValidator
{
    private const MESSAGE = 'This name is already in use.';

    /** @var CacheService Service for Cache */
    private CacheService $cacheService;


    /**
     * @param CacheService $cacheService
     * @param array $config
     */
    public function __construct( CacheService $cacheService, array $config = [] )
    {
        $this->cacheService = $cacheService;

        parent::__construct($config);
    }

    /**
     * @param Schema $model
     * @param $attribute
     *
     * @return void
     */
    public function validateAttribute( $model, $attribute ): void
    {
        if( $this->cacheService->getContentCacheFile($model->table_name) )
        {
            $this->addError($model, Schema::NAME, self::MESSAGE );
        }
    }
}