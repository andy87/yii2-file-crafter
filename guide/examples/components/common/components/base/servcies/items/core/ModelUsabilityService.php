<?php declare(strict_types=1);

namespace base\servcies\items\core;

use Yii;
use Exception;
use base\moels\items\core\BaseModel;
use interfaces\servcies\core\ModelUsabilityInterface;

/**
 * Model Usability
 *
 * @package app\common\components\base
 *
 * @tag: #base #usability #database
 */
abstract class ModelUsabilityService extends BaseService implements ModelUsabilityInterface
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