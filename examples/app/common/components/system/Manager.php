<?php

namespace app\common\components\system;

use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\base\BaseObject;

/**
 * Class Manager
 *
 * @package app\common\components
 *
 * @tag: #manager #common
 */
class Manager extends BaseObject
{
    /** @var ActiveRecord|string $modelClass класс модели */
    private ActiveRecord|string $modelClass;



    /**
     * @param string $modelClass
     * @param array $config
     */
    public function __construct(string $modelClass, array $config = [] )
    {
        parent::__construct($config);

        $this->modelClass = $modelClass;
    }

    /**
     * @return ActiveRecord|string
     */
    public function getClassName(): ActiveRecord|string
    {
        return $this->modelClass;
    }

    /**
     * @param array $params
     * @param bool $runSave
     *
     * @return ActiveRecord
     *
     * @throws Exception
     */
    public function create( array $params, bool $runSave = false ): ActiveRecord
    {
        $className = $this->getClassName();

        $activeRecord = new $className();

        $activeRecord->load( $params, '' );

        if ($runSave) {
            $activeRecord->save();
        }

        return $activeRecord;
    }

    /**
     * @param array $params
     *
     * @return ActiveRecord
     *
     * @throws Exception
     */
    public function add( array $params ): ActiveRecord
    {
        return $this->create($params, true);
    }

    /**
     * @param ActiveRecord $activeRecord
     * @param array $params
     *
     * @return ActiveRecord
     */
    public function update( ActiveRecord $activeRecord, array $params ): ActiveRecord
    {
        $activeRecord->load( $params, '' );

        return $activeRecord;
    }

    /**
     * @param array|string|int $criteria
     *
     * @return ?ActiveRecord
     */
    public function find( array|string|int $criteria ): ?ActiveRecord
    {
        $className = $this->getClassName();

        if ( is_int($criteria)) {
            $criteria = ['id' => $criteria];
        }

        /** @var ?ActiveRecord $activeRecord */
        $activeRecord = $className::find()->where($criteria)->one();

        return $activeRecord;
    }

}