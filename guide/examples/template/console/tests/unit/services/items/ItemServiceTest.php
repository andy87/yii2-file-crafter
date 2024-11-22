<?php declare(strict_types=1);

namespace app\console\tests\unit\services\items;

use app\console\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\ItemService };

/**
 * < Console > PascalCaseServiceTest
 *
 * @property ItemService $service
 *
 * @package app\console\tests\unit\services\items
 *
 * @tag #console #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var ItemService|string класс сервиса */
    public ItemService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}