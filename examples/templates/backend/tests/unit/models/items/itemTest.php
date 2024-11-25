<?php declare(strict_types=1);

namespace backend\tests\unit\models\items;

use app\common\components\core\{moels\items\base\BaseModel, tests\base\unit\models\BaseModelTest};
use backend\models\items\PascalCase;

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