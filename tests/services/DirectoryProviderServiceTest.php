<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use andy87\yii2\file_crafter\components\services\DirectoryProviderService;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;
use Yii;

/**
 * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\services
 *
 * @tag: #test #service #directory_provider
 */
class DirectoryProviderServiceTest extends UnitTestCore
{
    private const ALIAS = '@tests';
    private const DIRNAME = 'test_dir';
    private const PARAMS = [
        'dir' => self::ALIAS. DIRECTORY_SEPARATOR . self::DIRNAME,
        'ext' => '.test',
    ];

    /**
     * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox --filter testDirectoryProviderService
     *
     * @return void
     */
    public function testDirectoryProviderService(): void
    {
        $directoryProviderService = new DirectoryProviderService(self::PARAMS);

        $dir = __DIR__;
        Yii::setAlias(self::ALIAS, $dir);

        $dirAlias = $directoryProviderService->getDir(false);

        $this->assertEquals($dir, $dirAlias);

        //$fullPath = $directoryProviderService->getDir();

        //$this->assertEquals($dir . DIRECTORY_SEPARATOR . self::DIRNAME, $fullPath);


        //getExt

        //$ext = $directoryProviderService->getExt();

        //$this->assertEquals(self::PARAMS['ext'], $ext);

        //constructPath

        //$fileName = 'testFileName';

        //$constructPath = $directoryProviderService->constructPath($fileName);
        //$filePath = $dir . DIRECTORY_SEPARATOR . self::DIRNAME . DIRECTORY_SEPARATOR . $fileName . self::PARAMS['ext'];
        //$this->assertEquals($filePath, $constructPath);

        //$constructPath = $directoryProviderService->constructPath($fileName, false);
        //$filePath = self::PARAMS['dir'] . DIRECTORY_SEPARATOR . $fileName . self::PARAMS['ext'];
        //$this->assertEquals($filePath, $constructPath);
    }
}