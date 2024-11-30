<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\services\items;

use app\common\components\base\services\items\BaseService;
use app\common\components\traits\services\ApplyServiceTrait;
use app\common\components\base\tests\unit\source\items\BaseUnitTest;

/**
 * < Common > Base Service Test
 *
 * @property BaseService $service
 * @property BaseService|string $classnameService
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/service/BaseServiceTest
 *
 * @tag: #abstract #base #test #service
 */
abstract class BaseServiceTest extends BaseUnitTest
{
    use ApplyServiceTrait;

    // {{Parent}}
}