<?php declare(strict_types=1);

namespace app\backend\tests\unit\services\items;

use app\backend\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\ItemService };

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property ItemService $service
 *
 * @package app\backend\tests\unit\services\items
 *
 * @tag #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var ItemService|string класс сервиса */
    public ItemService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}