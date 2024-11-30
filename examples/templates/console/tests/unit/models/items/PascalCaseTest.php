<?php declare(strict_types=1);

namespace app\console\tests\unit\models\items;

use app\common\components\base\{moels\items\base\SourceModel};
use app\console\models\items\PascalCase;
use unit\models\items\BaseModelTest;

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
 * @tag: #boilerplate #console #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    protected SourceModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}