<?php declare(strict_types=1);

namespace app\backend\tests\unit\services\items;

use app\backend\components\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\BaseHandler };

/**
 * < Backend > PascalCaseServiceTest
 *
 * @property BaseHandler $service
 *
 * @package app\backend\tests\unit\services\items
 *
 * @tag #backend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseHandler|string класс сервиса */
    public BaseHandler|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}