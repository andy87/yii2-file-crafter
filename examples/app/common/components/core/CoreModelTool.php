<?php declare(strict_types=1);

namespace app\common\components\base;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\services\items\base\BaseService;
use app\common\components\interfaces\services\base\ModelUsabilityInterface;

/**
 * < Common > Родительский класс дающий доступ к базовым методам для работы с моделями
 *
 * @package app\common\components\core
 *
 * @tag: #abstract #base #tools #model
 */
abstract class CoreModelTool extends BaseService implements ModelUsabilityInterface
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