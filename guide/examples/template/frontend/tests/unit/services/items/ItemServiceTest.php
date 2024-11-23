<?php declare(strict_types=1);

namespace app\frontend\tests\unit\services\items;

use app\frontend\components\services\items\PascalCaseService;
use app\common\components\base\{ tests\unit\services\BaseServiceTest, services\items\BaseHandler };

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @property BaseHandler $service
 *
 * @package app\frontend\tests\unit\services\items
 *
 * @tag #frontend #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseHandler|string класс сервиса */
    public BaseHandler|string $classnameService = PascalCaseService::class;

    // {{Boilerplate}}
}