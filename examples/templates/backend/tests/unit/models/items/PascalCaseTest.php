<?php declare(strict_types=1);

namespace app\backend\tests\unit\models\items;

use app\backend\models\items\PascalCase;
use app\common\components\base\{moels\items\base\SourceModel};
use unit\models\items\BaseModelTest;

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
 * @tag: #boilerplate #backend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    protected SourceModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}