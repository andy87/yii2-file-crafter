<?php declare(strict_types=1);

namespace app\frontend\tests\unit\services\items;

use app\frontend\components\services\items\PascalCaseService;
use app\common\components\core\{services\items\base\BaseService, tests\base\unit\services\BaseServiceTest};

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @property BaseService $service
 *
 * @package app\frontend\tests\unit\services\items
 *
 * @tag #frontend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseService|string класс сервиса */
    public BaseService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}