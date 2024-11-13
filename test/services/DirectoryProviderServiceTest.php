<?php

namespace andy87\yii2\file_crafter\test\services;

use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\services\DirectoryProviderService;

/**
 * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\services
 *
 * @tag: #test #service #directory_provider
 */
class DirectoryProviderServiceTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox --filter testDirectoryProviderService
     *
     * @return void
     */
    public function testDirectoryProviderService(): void
    {
        $directoryProviderService = new DirectoryProviderService();

        $this->assertInstanceof(DirectoryProviderService::class, $directoryProviderService);
    }
}