<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\services;

use app\common\components\traits\ApplyServiceTrait;
use app\common\components\base\{ tests\unit\core\BaseUnitTest, services\items\BaseHandler };

/**
 * < Common > Base Service Test
 *
 * @property BaseHandler $service
 * @property BaseHandler|string $classnameService
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/service/BaseServiceTest
 *
 * @tag: #base #test #service
 */
abstract class BaseServiceTest extends BaseUnitTest
{
    use ApplyServiceTrait;

    // {{Parent}}
}