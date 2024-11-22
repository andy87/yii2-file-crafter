<?php declare(strict_types=1);

namespace app\backend\tests\unit\models\items;

use app\backend\models\items\PascalCase;
use app\common\components\base\{ tests\unit\models\BaseModelTest, moels\items\core\BaseModel };

/**
 * < Backend > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method PascalCase testInspectAttributes()
 *
 * @package app\backend\tests\unit\models\items
 *
 * @tag #backend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}