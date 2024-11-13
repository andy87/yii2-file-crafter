<?php

namespace andy87\yii2\file_crafter\test\services;

use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\services\CacheService;

/**
 * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\services
 *
 * @tag: #test #service #cache
 */
class CacheServiceTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testCacheService
     *
     * @return void
     */
    public function testCacheService(): void
    {
        $cacheService = new CacheService();

        $this->assertInstanceof(CacheService::class, $cacheService);
    }
}