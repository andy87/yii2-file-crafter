<?php declare(strict_types=1);

namespace app\console\tests\unit\services\items;

use app\common\components\base\{services\items\base\SourceService};
use app\console\components\services\items\PascalCaseService;

/**
 * < Console > PascalCaseServiceTest
 *
 * @property SourceService $service
 *
 * @package app\console\tests\unit\services\items
 *
 * @tag: #boilerplate #console #test #service
 */
class PascalCaseServiceTest extends \unit\services\items\BaseServiceTest
{
    /** @var SourceService|string класс сервиса */
    public SourceService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}