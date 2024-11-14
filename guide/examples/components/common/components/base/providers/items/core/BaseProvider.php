<?php declare(strict_types=1);

namespace base\providers\items\core;

use base\Logger;
use base\moels\items\core\BaseModel;
use base\servcies\items\core\ModelUsabilityService;
use Exception;
use interfaces\provider\ProviderInterface;

/**
 * Base class for all providers
 *
 * @package common\components\base\providers
 *
 * @property ?string $db
 * @property BaseModel|string $modelClass
 *
 * @tag: #base #provider
 */
abstract class BaseProvider extends ModelUsabilityService implements ProviderInterface
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
    public function create( array $params, bool $runSave = false ): ?BaseModel
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