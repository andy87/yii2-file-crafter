<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models\items;

use app\common\components\core\{moels\items\base\BaseModel, tests\base\unit\models\BaseModelTest};
use app\frontend\models\items\PascalCase;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\frontend\tests\unit\models\items
 *
 * @tag #frontend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}