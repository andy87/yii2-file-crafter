<?php declare(strict_types=1);

namespace common\tests\unit\models\items;

use app\common\components\core\{moels\items\base\BaseModel, tests\base\unit\models\BaseModelTest};

/**
 * < Common > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method \common\models\items\PascalCase testInspectAttributes()
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag #common #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass = \common\models\items\PascalCase::class;

    // {{Boilerplate}}
}