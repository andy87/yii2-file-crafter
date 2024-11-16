<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;
use Yii;

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




    /**
     * @return void
     **/
    public function setUp(): void
    {
        parent::setUp();

        $this->cacheService = new CacheService(self::PARAMS);

        if ( ! isset(Yii::$aliases['@app']) )
        {
            Yii::setAlias('@app', __DIR__ );
        }

        $dir = $this->cacheService->getDir();

        $this->cacheService->params['isExist'] = is_dir($dir);
        $this->cacheService->params['isWritable'] = is_writable($dir);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testGetCacheFileList
     *
     * @return void
     **/
    public function testGetCacheFileList(): void
    {
        if ( $this->hasDirectoryAccess() )
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

            $this->infoMessage();
        }
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testGetContentCacheFile
     *
     * @return void
     **/
    public function testGetContentCacheFile(): void
    {
        if ( $this->hasDirectoryAccess() )
        {
            $fileName = self::FILES[0];

            $fielContent = date('Y-m-d H:i:s');

            $filePath = $this->cacheService->constructPath($fileName);

            file_put_contents( $filePath, $fielContent );

            $content = $this->cacheService->getContentCacheFile($fileName);

            $this->assertEquals($content, $fielContent);

        } else {

            $this->infoMessage();
        }
    }

    /**
     * @cli vendor/bin/phpunit tests/services/CacheServiceTest.php --testdox --filter testRemoveItem
     *
     * @return void
     **/
    public function testRemoveItem(): void
    {
        if ( $this->hasDirectoryAccess() )
        {
            $fileName = self::FILES[0];

            $filePath = $this->cacheService->constructPath($fileName);

            if (file_exists($filePath)) unlink($filePath);

            file_put_contents( $filePath, 'test' );

            $this->assertTrue(file_exists($filePath));

            $this->cacheService->removeItem($fileName);

            $this->assertFalse(file_exists($filePath));

        } else {

            $this->infoMessage();
        }
    }

    /**
     * @return bool
     **/
    private function hasDirectoryAccess(): bool
    {
        $params = $this->cacheService->params;

        return $params['isExist'] && $params['isWritable'];
    }

    /**
     * @return void
     **/
    private function infoMessage(): void
    {
        $dirNotFound = !$this->cacheService->params['isExist'];
        $writableAccessDenied = !$this->cacheService->params['isExist'];

        if ( $dirNotFound )
        {
            $this->markTestIncomplete('No runtime directory');

        } else {

            if ( $writableAccessDenied )
            {
                $this->markTestIncomplete('No write permission to runtime');
            }
        }
    }
}