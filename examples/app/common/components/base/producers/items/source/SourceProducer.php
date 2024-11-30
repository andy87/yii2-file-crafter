<?php declare(strict_types=1);

namespace app\common\components\base\producers\items\source;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\system\Logger;
use app\common\components\system\Manager;
use Exception;

/**
 * < Common > Родительский абстрактный класс для всех провайдеров
 *  использующих BaseModel
 *
 * @package app\common\components\base\producers
 *
 * @tag: #abstract #common #producer #base #source
 */
abstract class SourceProducer implements ProducerInterface
{
    /** @var \app\common\components\system\Manager  */
    public Manager $model;

    /** @var \app\common\components\system\Manager */
    public Manager $form;


    /** @var array  */
    public array $defaultModelParams = [];



    /**
     * @param string $modelClass
     * @param string $formClass
     *
     * @return void
     */
    public function __construct( string $modelClass, string $formClass )
    {
        $this->model = new Manager( $modelClass );

        $this->form = new Manager( $formClass );
    }

    /**
     * @param array $params
     *
     * @throws \yii\db\Exception
     */
    public function modelCreate( mixed $params, bool $runSave = false ): ?SourceModel
    {
        /** @var ?SourceModel $model */
        $model = $this->model->create($params);

        return $model;
    }

    /**
     * @param array $params
     *
     * @throws \yii\db\Exception
     */
    public function modelAdd( mixed $params ): ?SourceModel
    {
        return $this->modelCreate( $params, true );
    }

    /**
     * @param SourceModel $sourceModel
     * @param mixed $params
     *
     * @return ?SourceModel
     */
    public function modelUpdate( SourceModel $sourceModel, mixed $params ): ?SourceModel
    {
        /** @var SourceModel $model */
        $model = $this->model->update( $sourceModel, $params );

        return $model;
    }

    /**
     * @param array $params
     *
     * @throws \yii\db\Exception
     */
    public function formCreate( mixed $params, bool $runSave = false ): ?SourceModel
    {
        /** @var ?SourceModel $form */
        $form = $this->model->create($params);

        return $form;
    }

    /**
     * @param array $params
     *
     * @throws \yii\db\Exception
     */
    public function formAdd( mixed $params ): ?SourceModel
    {
        return $this->modelCreate( $params, true );
    }

    /**
     * @param SourceModel $sourceForm
     * @param mixed $params
     *
     * @return ?SourceModel
     */
    public function formUpdate( SourceModel $sourceForm, mixed $params ): ?SourceModel
    {
        /** @var SourceModel $form */
        $form = $this->form->update( $sourceForm, $params );

        return $form;
    }
}