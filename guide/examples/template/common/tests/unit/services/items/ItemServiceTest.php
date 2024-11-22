<?php declare(strict_types=1);

namespace app\common\tests\unit\services\items;

use app\common\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\ItemService };

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\services\items
 *
 * @tag #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var ItemService|string класс сервиса */
    public ItemService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}