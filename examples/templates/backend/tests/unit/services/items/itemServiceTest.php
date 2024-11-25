<?php declare(strict_types=1);

namespace backend\tests\unit\services\items;

use app\common\components\core\{services\items\base\BaseService, tests\base\unit\services\BaseServiceTest};
use backend\components\services\items\PascalCaseService;

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