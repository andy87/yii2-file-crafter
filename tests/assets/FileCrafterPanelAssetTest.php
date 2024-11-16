<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\assets;

use yii\web\YiiAsset;
use andy87\yii2\file_crafter\components\assets\FileCrafterPanelAsset;
use andy87\yii2\file_crafter\components\assets\SortableAsset;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/assets/FileCrafterPanelAssetTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\assets
 *
 * @tag: #test #asset #file_crafter
 */
class FileCrafterPanelAssetTest extends UnitTestCore
{
    private const CSS_FILE = 'css/file-crafter.css';

    private const JS_FILE = 'js/file-crafter.js';

    private const DEPENDS = [
        YiiAsset::class,
        SortableAsset::class,
    ];



    /**
     * @cli vendor/bin/phpunit tests/assets/FileCrafterPanelAssetTest.php --testdox --filter testFileCrafterPanelAsset
     */
    public function testFileCrafterPanelAsset(): void
    {
        $fileCrafterPanelAsset = new FileCrafterPanelAsset();

        foreach (self::DEPENDS as $depend) {
            $this->assertTrue(in_array($depend, $fileCrafterPanelAsset->depends));
        }

        $this->assertTrue(in_array(self::CSS_FILE, $fileCrafterPanelAsset->css));

        $this->assertTrue(in_array(self::JS_FILE, $fileCrafterPanelAsset->js));
    }
}