<?php declare(strict_types=1);

namespace console\tests\unit\models\items;

use app\common\components\core\{moels\items\base\BaseModel, tests\base\unit\models\BaseModelTest};
use console\models\items\PascalCase;

/**
 * < Console > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\console\tests\unit\models\items
 *
 * @tag #console #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}