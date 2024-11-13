<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\assets;

use andy87\yii2\file_crafter\components\assets\SortableAsset;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;
use Yii;
use yii\base\InvalidConfigException;

/**
 * @cli vendor/bin/phpunit tests/assets/SortableAssetTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\assets
 *
 * @tag: #test #asset #sortable
 */
class SortableAssetTest extends UnitTestCore
{
    /** @var string  */
    private const JS_FILE = 'js/sortable.js';



    /**
     * @cli vendor/bin/phpunit tests/assets/SortableAssetTest.php --testdox --filter testSortableAsset
     *
     * @throws InvalidConfigException
     */
    public function testSortableAsset()
    {
        /** @var SortableAsset $sortableAsset */
        $sortableAsset = Yii::createObject(SortableAsset::class);

        // in array 'js/sortable.js'
        $this->assertTrue(in_array(self::JS_FILE, $sortableAsset->js));
    }
}