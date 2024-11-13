<?php

namespace andy87\yii2\file_crafter\test\assets;

use Yii;
use yii\base\InvalidConfigException;
use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\assets\SortableAsset;

/**
 * @cli vendor/bin/phpunit tests/assets/SortableAssetTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\assets
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