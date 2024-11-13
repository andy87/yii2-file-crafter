<?php


namespace andy87\yii2\file_crafter\test\services;

use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\services\PanelService;

/**
 * @cli vendor/bin/phpunit tests/services/PanelServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\services
 *
 * @tag: #test #service #panel
 */
class PanelServiceTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/services/PanelServiceTest.php --testdox --filter testPanelService
     *
     * @return void
     */
    public function testPanelService(): void
    {
        $sourceParams = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        $cacheParams = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        $customFields = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        $panelService = new PanelService( $sourceParams, $cacheParams, $customFields );

        $this->assertInstanceof(PanelService::class, $panelService);
    }
}