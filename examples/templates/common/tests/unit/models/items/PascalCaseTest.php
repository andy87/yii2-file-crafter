<?php declare(strict_types=1);

namespace app\common\tests\unit\models\items;

use app\common\components\base\{moels\items\base\SourceModel};

/**
 * < Common > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest
 *
 * @cli ./vendor/bin/codecept run app/common/tests/unit/models/items/PascalCaseTest:testInspectAttributes
 * @method \app\common\models\items\PascalCase testInspectAttributes()
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag: #boilerplate #common #test #model
 */
class PascalCaseTest extends \unit\models\items\BaseModelTest
{
    /** @var SourceModel|string $modelClass */
    protected SourceModel|string $modelClass = \app\common\models\items\PascalCase::class;

    // {{Boilerplate}}
}