<?php declare(strict_types=1);

namespace app\console\tests\unit\services\items;

use app\console\components\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\BaseHandler };

/**
 * < Console > PascalCaseServiceTest
 *
 * @property BaseHandler $service
 *
 * @package app\console\tests\unit\services\items
 *
 * @tag #console #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseHandler|string класс сервиса */
    public BaseHandler|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}