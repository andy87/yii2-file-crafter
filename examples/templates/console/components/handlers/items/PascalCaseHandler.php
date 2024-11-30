<?php declare(strict_types=1);

namespace app\console\components\handlers\items;

use Exception;
use yii\base\InvalidConfigException;
use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\console\models\search\items\PascalCaseSearch;
use app\common\components\traits\services\ApplyServiceTrait;
use app\console\components\services\items\PascalCaseService;
use app\console\components\producers\items\PascalCaseProducer;
use app\console\components\repository\items\PascalCaseRepository;
use app\console\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @method PascalCaseService getService()
 *
 * @package app\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \app\common\components\handlers\items\PascalCaseHandler
{
    use ApplyServiceTrait;

    public const MODEL_CLASS = PascalCase::class;
    public const FORM_CLASS = PascalCaseForm::class;
    public const SEARCH_MODEL_CLASS = PascalCaseSearch::class;
    public const DATA_PROVIDER_CLASS = PascalCaseDataProvider::class;
    public const PRODUCER_CLASS = PascalCaseProducer::class;
    public const REPOSITORY_CLASS = PascalCaseRepository::class;



    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processView( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function processCreateModel( array $params ): ?PascalCase
    {
        /** @var ?PascalCase $model */
        $model = $this->getService()->producer->model->create($params);

        return $model;
    }

    /**
     * @param array $params
     *
     * @return ?PascalCaseForm
     *
     * @throws InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function processCreateForm(array $params ): ?PascalCaseForm
    {
        /** @var ?PascalCaseForm $form */
        $form = $this->getService()->producer->form->create( $params );

        return $form;
    }

    /**
     * @throws InvalidConfigException|Exception
     */
    public function processUpdateModel( int $id, array $params ): ?PascalCase
    {
        $model = $this->findByID($id);

        if ( $model )
        {
            return $this->getService()->updateModel( $model, $params );
        }

        return null;
    }

    /**
     * @throws InvalidConfigException|Exception
     */
    public function processUpdateForm(int $id, array $params ): ?PascalCase
    {
        $form = $this->findByID($id);

        if ( $form )
        {
            return $this->getService()->updateModel( $form, $params );
        }

        return null;
    }

    /**
     * @throws InvalidConfigException
     */
    public function processDelete( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException|Exception
     */
    private function findByID( int $id ): ?PascalCase
    {
        return $this->getService()->getItemById($id);
    }
}