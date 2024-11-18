<?php declare(strict_types=1);

namespace app\common\components\base;

use app\common\components\interfaces\services\core\ModelUsabilityInterface;
use app\common\components\{ base\moels\items\core\BaseModel, base\services\items\core\BaseService };

/**
 * < Common > Родительский класс дающий доступ к базовым методам для работы с моделями
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