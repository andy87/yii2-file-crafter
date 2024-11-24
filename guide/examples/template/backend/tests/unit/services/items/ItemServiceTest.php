<?php declare(strict_types=1);

namespace app\backend\tests\unit\services\items;

use app\backend\components\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\BaseService };

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property BaseService $service
 *
 * @package app\backend\tests\unit\services\items
 *
 * @tag #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseService|string класс сервиса */
    public BaseService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}