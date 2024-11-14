<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use Yii;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;
use andy87\yii2\file_crafter\components\services\DirectoryProviderService;

/**
 * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\services
 *
 * @tag: #test #service #directory_provider
 */
class DirectoryProviderServiceTest extends UnitTestCore
{
    private const TEST_DIR = __DIR__;

    private const ALIAS = '@tests';
    private const DIRNAME = 'test_dir';
    private array $params = [];

    private DirectoryProviderService $directoryProviderService;


    public function setUp(): void
    {
        parent::setUp();

        $this->params = [
            'dir' => self::ALIAS . '/' . self::DIRNAME,
            'ext' => '.test',
        ];

        Yii::setAlias(self::ALIAS, $this->changeSlash(self::TEST_DIR));

        $this->directoryProviderService = new DirectoryProviderService($this->params);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox --filter testGetDir
     *
     * @return void
     */
    public function testGetDir(): void
    {
        $getDir = $this->directoryProviderService->getDir(false);

        $this->assertEquals(
             $this->changeSlash($this->params['dir']),
            $this->changeSlash($getDir)
        );

        $fullPath = self::TEST_DIR . DIRECTORY_SEPARATOR . self::DIRNAME;
        $getDir = $this->directoryProviderService->getDir();

        $this->assertEquals(
            $this->changeSlash($fullPath),
            $this->changeSlash($getDir)
        );
    }

    /**
     * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox --filter testGetExt
     *
     * @return void
     */
    public function testGetExt(): void
    {
        $this->assertEquals( $this->params['ext'], $this->directoryProviderService->getExt() );
    }

    /**
     * @cli vendor/bin/phpunit tests/services/DirectoryProviderServiceTest.php --testdox --filter testConstructPath
     *
     * @return void
     */
    public function testConstructPath(): void
    {
        $fileName = 'testFileName';

        $constructPath = $this->directoryProviderService->constructPath($fileName);
        $filePath = self::TEST_DIR . DIRECTORY_SEPARATOR . self::DIRNAME . DIRECTORY_SEPARATOR . $fileName . $this->params['ext'];

        $this->assertEquals(
            $this->changeSlash($constructPath),
            $this->changeSlash($filePath)
        );

        $constructPath = $this->directoryProviderService->constructPath($fileName, false);
        $filePath = $this->params['dir'] . DIRECTORY_SEPARATOR . $fileName . $this->params['ext'];

        $this->assertEquals(
            $this->changeSlash($constructPath),
            $this->changeSlash($filePath)
        );
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function changeSlash(string $path): string
    {
        return str_replace(['/','\\'], '/', $path);
    }
}