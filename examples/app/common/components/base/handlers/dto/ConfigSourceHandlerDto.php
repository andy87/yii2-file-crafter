<?php

namespace app\common\components\base\handlers\dto;

use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\interfaces\models\SearchModelInterface;

/**
 * < Common > DTO класс для конфигурации `Обработчика запросов`
 *
 * @package app\common\components\models\dto\handlers
 *
 * @tag: #common #models #dto #handler #config
 */
class ConfigSourceHandlerDto
{
    /** @var SourceModel|string Класс `модели` */
    public SourceModel|string $classModel;

    /** @var SourceModel|string Класс `формы` */
    public SourceModel|string $classForm;


    /** @var SourceProducer|string Класс `Продюсера` */
    public SourceProducer|string $classProducer;



    /** @var SourceRepository|string Класс `Репозитория` */
    public SourceRepository|string $classRepository;



    /** @var SearchModelInterface|string Класс `Модели поиска` */
    public SearchModelInterface|string $classSearchModel;

    /** @var SourceActiveDataProvider|string Класс `Провайдера данных` */
    public SourceActiveDataProvider|string $classDataProvider;
}