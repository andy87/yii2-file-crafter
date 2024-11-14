<?php declare(strict_types=1);

namespace common\components\base;

use base\moels\items\core\BaseModel;
use base\services\items\core\BaseService;
use interfaces\services\core\ModelUsabilityInterface;

/**
 * Родительский класс дающий доступ к базовым методам для работы с моделями
 *
 * @package app\common\components\base
 *
 * @tag: #base #tools #model
 */
abstract class BaseModelTool extends BaseService implements ModelUsabilityInterface
{
    /** @var BaseModel|string  */
    protected BaseModel|string $modelClass;



    /**
     * @param array $params
     *
     * @return BaseModel
     */
    public function getModel( array $params = []): BaseModel
    {
        $className = $this->getModelClass();

        return new $className($params);
    }

    /**
     * @return BaseModel|string
     */
    public function getModelClass(): BaseModel|string
    {
        return $this->modelClass;
    }
}