<?php declare(strict_types=1);

namespace app\backend\tests\unit\services\items;

use app\backend\components\services\items\PascalCaseService;
use app\common\components\base\{services\items\base\SourceService};
use unit\services\items\BaseServiceTest;

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package app\backend\tests\unit\services\items
 *
 * @tag: #boilerplate #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}