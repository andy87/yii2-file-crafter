<?php declare(strict_types=1);

namespace app\common\tests\unit\services\items;

use app\common\components\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\BaseHandler };

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\services\items
 *
 * @tag #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseHandler|string класс сервиса */
    public BaseHandler|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}