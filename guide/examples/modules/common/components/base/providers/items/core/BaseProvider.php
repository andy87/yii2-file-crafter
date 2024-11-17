<?php declare(strict_types=1);

namespace app\common\components\base\providers\items\core;

use Exception;
use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\BaseModelTool;
use interfaces\provider\ProviderInterface;

/**
 * Родительский абстрактный класс для всех провайдеров
 *  использующих BaseModel
 *
 * @package app\common\components\base\providers
 *
 * @property BaseModel|string $modelClass
 *
 * @tag: #base #provider
 */
abstract class BaseProvider extends BaseModelTool implements ProviderInterface
{
    /** @var array  */
    public array $defaultModelParams = [];



    /**
     * @param array $params
     * @param bool $runSave
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function create( array $params = [], bool $runSave = false ): ?BaseModel
    {
        try
        {
            $params = array_merge( $this->defaultModelParams, $params );

            $model = $this->getModel( $params );

            if( $runSave ) {
                $model->save();
            }

            return $model;

        } catch (Exception $e) {

            $this->handlerCatch( $e, __METHOD__, 'Error! on create model', [
                'params' => $params,
                'runSave' => $runSave
            ]);
        }

        return null;
    }

    /**
     * @param array $params
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function add( array $params ): ?BaseModel
    {
        return $this->create( $params, true );
    }
}