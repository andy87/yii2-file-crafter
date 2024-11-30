<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items\source;

use AllowDynamicProperties;
use app\common\components\base\handlers\dto\ConfigSourceHandlerDto;
use app\common\components\base\services\items\BaseService;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\traits\services\ApplyServiceTrait;
use yii\base\BaseObject;

/**
 * < Common > Родительский абстрактный класс для всех обработчиков
 *
 * @property array $configService;
 * @property ConfigSourceHandlerDto $configSourceHandlerDto
 *
 * @method BaseService getService()
 *
 * @package app\common\components\base\handlers\items\core
 *
 * @tag: #abstract #common #handler #base
 */
#[AllowDynamicProperties]
abstract class SourceHandler extends BaseObject implements HandlerInterface
{
    use ApplyServiceTrait;



    /**
     * @param ConfigSourceHandlerDto $configSourceHandlerDto Конфигурация `Обработчика запросов`
     */
    public function __construct(private readonly ConfigSourceHandlerDto $configSourceHandlerDto, $config = [] )
    {
        parent::__construct($config);

        $this->setupServiceConfig($configSourceHandlerDto);
    }

    /**
     * @param ConfigSourceHandlerDto $configSourceHandlerDto
     *
     * @return void
     */
    private function setupServiceConfig(ConfigSourceHandlerDto $configSourceHandlerDto): void
    {
        $configService = [];

        if (isset($configSourceHandlerDto->classSearchModel))
        {
            $configService['searchModelClass'] = $configSourceHandlerDto->classSearchModel;
        }

        if (isset($configSourceHandlerDto->classDataProvider))
        {
            $configService['dataProviderClass'] = $configSourceHandlerDto->classDataProvider;
        }

        if (isset($configSourceHandlerDto->classProducer))
        {
            $configService['configProducer'] =[
                'class' => $configSourceHandlerDto->classProducer,
                'modelClass' => $configSourceHandlerDto->classModel,
            ];
        }

        if (isset($configSourceHandlerDto->classProducer))
        {
            $configService['configRepository'] =[
                'class' => $configSourceHandlerDto->classRepository,
                'modelClass' => $configSourceHandlerDto->classModel,
            ];
        }

        $this->configService = $configService;
    }
}