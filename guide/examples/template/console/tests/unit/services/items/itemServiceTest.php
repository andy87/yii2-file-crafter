<?php declare(strict_types=1);

namespace app\console\tests\unit\services\items;

use app\common\components\core\{services\items\base\BaseService, tests\base\unit\services\BaseServiceTest};
use app\console\components\services\items\PascalCaseService;

/**
 * < Console > PascalCaseServiceTest
 *
 * @property BaseService $service
 *
 * @package app\console\tests\unit\services\items
 *
 * @tag #console #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseService|string класс сервиса */
    public BaseService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}