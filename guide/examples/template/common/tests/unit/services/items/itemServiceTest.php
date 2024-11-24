<?php declare(strict_types=1);

namespace app\common\tests\unit\services\items;

use app\common\components\services\items\PascalCaseService;
use app\common\components\base\{ services\items\core\BaseService, tests\unit\services\BaseServiceTest};

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