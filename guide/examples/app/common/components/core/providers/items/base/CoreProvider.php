<?php declare(strict_types=1);

namespace app\common\components\core\providers\items\base;

use Exception;
use app\common\components\{ base\CoreModelTool, interfaces\providers\ProviderInterface, core\moels\items\base\BaseModel };

/**
 * < Common > Родительский абстрактный класс для всех провайдеров
 *  использующих BaseModel
 *
 * @package app\common\components\core\providers
 *
 * @property BaseModel|string $modelClass
 *
 * @tag: #abstract #base #provider
 */
abstract class CoreProvider extends CoreModelTool implements ProviderInterface
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