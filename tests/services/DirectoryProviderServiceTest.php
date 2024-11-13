<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use andy87\yii2\file_crafter\components\services\DirectoryProviderService;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\services
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