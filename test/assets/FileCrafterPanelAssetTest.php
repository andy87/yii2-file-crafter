<?php

namespace andy87\yii2\file_crafter\test\assets;

use Yii;
use yii\web\YiiAsset;
use yii\base\InvalidConfigException;
use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\assets\SortableAsset;
use andy87\yii2\file_crafter\components\assets\FileCrafterPanelAsset;

/**
 * @cli vendor/bin/phpunit tests/assets/FileCrafterPanelAssetTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\assets
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
     *
     * @throws InvalidConfigException
     */
    public function testFileCrafterPanelAsset(): void
    {
        /** @var FileCrafterPanelAsset $fileCrafterPanelAsset */
        $fileCrafterPanelAsset = Yii::createObject(FileCrafterPanelAsset::class);

        foreach (self::DEPENDS as $depend) {
            $this->assertTrue(in_array($depend, $fileCrafterPanelAsset->depends));
        }

        $this->assertTrue(in_array(self::CSS_FILE, $fileCrafterPanelAsset->css));

        $this->assertTrue(in_array(self::JS_FILE, $fileCrafterPanelAsset->js));
    }
}