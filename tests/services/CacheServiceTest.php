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
    /** @var string[]  */
    private const PARAMS = [
        'dir' => '@app/runtime',
        'ext' => '.json',
    ];

    private const FILES = ['yii2-unit-test-file-1.json','yii2-unit-test-file-2.json'];

    /** @var CacheService */
    private CacheService $cacheService;


    /** @return void */
    public function setUp(): void
    {
        parent::setUp();

        $this->cacheService = new CacheService(self::PARAMS);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testGetCacheFileList
     *
     * @return void
     */
    public function testGetCacheFileList(): void
    {
        //проверка прав на запись в runtime
        if( is_writable( $this->cacheService->getDir() ) )
        {
            foreach (self::FILES as $index => $file)
            {
                $filePath = $this->cacheService->constructPath($file);

                if (file_exists($filePath)) continue;

                file_put_contents( $filePath, "test_$index" );
            }

            $list = $this->cacheService->getCacheFileList();

            $this->assertNotEmpty($list);

            $this->assertTrue(in_array('test1.json', $list));
            $this->assertTrue(in_array('test2.json', $list));

            foreach (self::FILES as $file)
            {
                $filePath = $this->cacheService->constructPath($file);

                if (file_exists($filePath)) unlink($filePath);
            }

        } else {
            $this->markTestIncomplete('No write permission to runtime');
        }
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testGetContentCacheFile
     *
     * @return void
     */
    public function testGetContentCacheFile(): void
    {
        $fileName = self::FILES[0];

        $fielContent = date('Y-m-d H:i:s');

        $filePath = $this->cacheService->constructPath($fileName);

        file_put_contents( $filePath, $fielContent );

        $content = $this->cacheService->getContentCacheFile($fileName);

        $this->assertEquals($content, $fielContent);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testRemoveItem
     *
     * @return void
     */
    public function testRemoveItem(): void
    {
        $fileName = self::FILES[0];

        $filePath = $this->cacheService->constructPath($fileName);

        if (file_exists($filePath)) unlink($filePath);

        file_put_contents( $filePath, 'test' );

        $this->assertTrue(file_exists($filePath));

        $this->cacheService->removeItem($fileName);

        $this->assertFalse(file_exists($filePath));
    }
}