<?php declare(strict_types=1);

namespace base\servcies\items\core;

use Yii;
use Exception;
use yii\base\BaseObject;
use base\moels\items\core\BaseModel;
use interfaces\servcies\core\ModelUsabilityInterface;

/**
 * Model Usability
 *
 * @package app\common\components\base
 *
 * @tag: #base #usability #database
 */
abstract class ModelUsability extends BaseObject implements ModelUsabilityInterface
{
    /** @var string  */
    protected string $modelClass;

    /** @var ?string */
    protected ?string $db = null;



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

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return void
     *
     * @throws Exception
     */
    public function handlerCatch( Exception $e, string $method, string $message, array $params ): void
    {
        if ($this->logger) {

            $this->logger->catcher($e, $method, $message, $params);

        } else {

            Yii::error([
                date('Y-m-d H:i:s') => $method,
                'message' => $message,
                'exception' => [
                    'message' => $e->getMessage(),
                    'position' => $e->getFile() . ':' . $e->getLine(),
                    'trace' => $e->getTrace(),
                ],
                'arguments' => $params
            ]);
        }
    }
}