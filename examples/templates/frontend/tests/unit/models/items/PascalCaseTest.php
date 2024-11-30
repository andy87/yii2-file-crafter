<?php declare(strict_types=1);

namespace app\frontend\tests\unit\models\items;

use app\common\components\base\{moels\items\base\SourceModel};
use app\frontend\models\items\PascalCase;
use unit\models\items\BaseModelTest;

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
 * @tag: #boilerplate #frontend #test #model
 */
class PascalCaseTest extends BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    protected SourceModel|string $modelClass = PascalCase::class;

    // {{Boilerplate}}
}