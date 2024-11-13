<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\assets;

use andy87\yii2\file_crafter\components\assets\SortableAsset;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

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
    private const JS_FILE = 'js/plugins/Sortable.min.js';



    /**
     * @cli vendor/bin/phpunit tests/assets/SortableAssetTest.php --testdox --filter testSortableAsset
     */
    public function testSortableAsset()
    {
        $sortableAsset = new SortableAsset();



        // in array 'js/sortable.js'
        $this->assertTrue(in_array(self::JS_FILE, $sortableAsset->js));
    }
}