<?php declare(strict_types=1);

namespace app\backend\components\handlers\items;

use app\backend\models\forms\items\PascalCaseForm;
use app\common\components\enums\Action;
use app\backend\models\items\PascalCase;
use app\backend\models\search\items\PascalCaseSearch;
use app\backend\components\handlers\parents\BackendHandler;
use app\backend\components\services\items\PascalCaseService;
use app\backend\components\producers\items\PascalCaseProducer;
use app\backend\components\repository\items\PascalCaseRepository;
use app\backend\components\resources\items\PascalCaseIndexResource;
use app\backend\components\resources\items\PascalCaseCreateResource;
use app\backend\components\resources\items\PascalCaseUpdateResource;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\backend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property array configService;
 * @method PascalCaseService getService()
 *
 * @package app\backend\components\handlers\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseHandler extends BackendHandler
{
    public const MODEL_CLASS = PascalCase::class;
    public const FORM_CLASS = PascalCaseForm::class;
    public const SEARCH_MODEL_CLASS = PascalCaseSearch::class;
    public const DATA_PROVIDER_CLASS = PascalCaseDataProvider::class;
    public const PRODUCER_CLASS = PascalCaseProducer::class;
    public const REPOSITORY_CLASS = PascalCaseRepository::class;



    /** @var array */
    public array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}