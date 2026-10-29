<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use Yii;
use yii\helpers\FileHelper;
use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * Verifies cache access using temporary schemas owned by each test.
 *
 * @package andy87\yii2\file_crafter\tests\services
 */
class CacheServiceTest extends ApplicationTestCore
{
    /** @var CacheService Cache isolated from application and developer files. */
    private CacheService $cacheService;

    /**
     * Create a writable cache without depending on a pre-existing runtime folder.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cacheService = new CacheService(['dir' => '@app/runtime/cache', 'ext' => '.json']);
        FileHelper::createDirectory($this->cacheService->getDir());
    }

    /** @return void Only schema files with the configured extension are listed. */
    public function testGetCacheFileList(): void
    {
        foreach (['test1', 'test2'] as $name) {
            file_put_contents($this->cacheService->constructPath($name), '{}');
        }
        file_put_contents(Yii::getAlias('@app/runtime/cache/ignore.txt'), 'not a schema');
        FileHelper::createDirectory(Yii::getAlias('@app/runtime/cache/directory.json'));

        $this->assertSame(['test1.json', 'test2.json'], $this->cacheService->getCacheFileList());
    }

    /** @return void Cached content is returned without adding another extension. */
    public function testGetContentCacheFile(): void
    {
        $content = '{"name":"Test"}';
        file_put_contents($this->cacheService->constructPath('test1'), $content);

        $this->assertSame($content, $this->cacheService->getContentCacheFile('test1'));
        $this->assertNull($this->cacheService->getContentCacheFile('missing'));
    }

    /** @return void Removing one schema preserves every other cached schema. */
    public function testRemoveItem(): void
    {
        $path = $this->cacheService->constructPath('test1');
        $other = $this->cacheService->constructPath('test2');
        file_put_contents($path, '{}');
        file_put_contents($other, '{}');

        $this->cacheService->removeItem('test1');

        $this->assertFileDoesNotExist($path);
        $this->assertFileExists($other);
    }
}
