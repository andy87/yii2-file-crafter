<?php declare(strict_types=1);

namespace app\common\tests\unit\services\items;

use app\common\components\core\{services\items\base\BaseService, tests\base\unit\services\BaseServiceTest};
use app\common\components\services\items\PascalCaseService;

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\services\items
 *
 * @tag #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseService|string класс сервиса */
    public BaseService|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}