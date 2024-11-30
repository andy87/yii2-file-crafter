<?php declare(strict_types=1);

namespace app\common\tests\unit\services\items;

use app\common\components\base\services\items\BaseService;
use app\common\components\services\items\PascalCaseService;
use app\common\components\base\tests\unit\services\items\BaseServiceTest;

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\services\items
 *
 * @tag: #boilerplate #common #test #service
 */
class PascalCaseServiceTest extends BaseServiceTest
{
    /** @var BaseService|string класс сервиса */
    public BaseService|string $classNameService = PascalCaseService::class;

    // {{Boilerplate}}
}