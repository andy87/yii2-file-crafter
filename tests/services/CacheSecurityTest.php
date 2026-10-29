<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\{BadRequestHttpException, ForbiddenHttpException};
use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * Protects cached schemas and files outside the cache from unsafe deletion.
 *
 * @package andy87\yii2\file_crafter\tests\services
 */
class CacheSecurityTest extends ApplicationTestCore
{
    /** @return void GET must never remove a schema, even with a valid name. */
    public function testGetCannotDelete(): void
    {
        $path = $this->createCachedSchema();
        $this->setRequest([], ['remove' => 'example']);
        $this->createCrafter();

        $this->assertFileExists($path);
    }

    /** @return void A confirmed POST with CSRF removes the requested schema. */
    public function testValidPostDeletes(): void
    {
        $path = $this->createCachedSchema();
        $this->setRequest(['remove' => 'example']);
        $this->createCrafter();

        $this->assertFileDoesNotExist($path);
    }

    /** @return void The server must enforce canDelete even for a direct POST. */
    public function testDisabledDeletionPreservesFile(): void
    {
        $path = $this->createCachedSchema();
        $this->setRequest(['remove' => 'example']);
        try {
            $this->createCrafter(['canDelete' => false]);
            $this->fail('Deletion must be forbidden.');
        } catch (ForbiddenHttpException $exception) {
            $this->assertFileExists($path);
        }
    }

    /** @return void A request without a token cannot delete files. */
    public function testDeletionRequiresCsrf(): void
    {
        $path = $this->createCachedSchema();
        $this->setRequest(['remove' => 'example'], [], false);
        try {
            $this->createCrafter();
            $this->fail('A missing CSRF token must be rejected.');
        } catch (BadRequestHttpException $exception) {
            $this->assertFileExists($path);
        }
    }

    /** @return void Shared cache paths must reject traversal before unlink(). */
    public function testTraversalCannotDeleteOutsideFile(): void
    {
        $this->createCrafter();
        $outside = $this->testRoot . '/composer.json';
        file_put_contents($outside, '{}');
        $cache = new CacheService();

        try {
            $cache->removeItem('../../../composer');
            $this->fail('An invalid cache name must be rejected.');
        } catch (InvalidArgumentException $exception) {
            $this->assertFileExists($outside);
        }
    }

    /**
     * Create a schema through the actual cache location.
     *
     * @return string Path of the test schema.
     */
    private function createCachedSchema(): string
    {
        $this->createCrafter();
        $path = (new CacheService())->constructPath('example');
        file_put_contents($path, '{"name":"Example","db_fields":[]}');

        return $path;
    }
}
