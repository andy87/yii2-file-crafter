<?php declare(strict_types=1);

namespace app\common\tests\unit\models\items;

use app\common\models\items\PascalCase;
use app\common\components\base\{ tests\unit\models\BaseModelTest, moels\items\core\BaseModel };

/**
 * < Common > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag #common #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}