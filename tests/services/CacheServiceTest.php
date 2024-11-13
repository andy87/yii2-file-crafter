<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\services
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
    }
}