<?php declare(strict_types=1);

namespace app\console\components\handlers\parents;

use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use app\common\components\base\handlers\dto\ConfigSourceHandlerDto;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\interfaces\models\SearchModelInterface;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property array $configService;
 * @property ConfigSourceHandlerDto $configSourceHandlerDto
 *
 * @package app\console\components\handlers\parents
 *
 * @tag: #abstract #console #parent #boilerplate #handler
 */
abstract class ConsoleHandler extends SourceHandler
{
    /** @var SourceModel|string Класс `модели` */
    public SourceModel|string $classModel;

    /** @var SearchModelInterface|string Класс `Модели поиска` */
    public SearchModelInterface|string $classSearchModel;

    /** @var SourceActiveDataProvider|string Класс `Провайдера данных` */
    public SourceActiveDataProvider|string $classDataProvider;

    /** @var SourceProducer|string Класс `Продюсера` */
    public SourceProducer|string $classProducer;

    /** @var SourceRepository|string Класс `Репозиторий` */
    public SourceRepository|string $classRepository;



    public function processIndex(): array
    {
        return [];
    }

    public function processCreate( string $json ): ?SourceModel
    {
        return new $this->classModel();
    }

    public function processView( int $id ): ?SourceModel
    {
        return new $this->classModel();
    }

    public function processUpdate( int $id, $json ): ?SourceModel
    {
        return new $this->classModel();
    }

    public function processDelete( int $id ): int
    {
        return 0;
    }
}