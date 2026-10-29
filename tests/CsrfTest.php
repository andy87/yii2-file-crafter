<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\gii\Module;
use yii\web\BadRequestHttpException;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * Exercises Gii's real initialization order to prevent writes before CSRF validation.
 *
 * @package andy87\yii2\file_crafter\tests
 */
class CsrfTest extends ApplicationTestCore
{
    /** @return void Gii must reject an untrusted create without writing its schema. */
    public function testGiiRejectsCreateBeforeWriting(): void
    {
        $this->setRequest(['create' => '', 'name' => 'Csrf Created'], [], false);
        Yii::$app->setModule('gii', [
            'class' => Module::class,
            'generators' => ['fileCrafter' => ['class' => Crafter::class]],
        ]);

        try {
            Yii::$app->runAction('gii/default/view', ['id' => 'fileCrafter']);
            $this->fail('The invalid request must fail.');
        } catch (BadRequestHttpException $exception) {
            $this->assertSame(400, $exception->statusCode);
            $this->assertFileDoesNotExist((new CacheService())->constructPath('csrf_created'));
        }
    }

    /** @return void An invalid update must preserve the original cached bytes. */
    public function testInvalidTokenCannotUpdate(): void
    {
        $this->createCrafter();
        $path = (new CacheService())->constructPath('original');
        $content = '{"name":"Original","custom_fields":{"label":"keep"}}';
        file_put_contents($path, $content);
        $this->setRequest(['update' => '', 'name' => 'Replaced', '_csrf' => 'invalid'], ['update' => 'original'], false);

        try {
            $this->createCrafter();
            $this->fail('The invalid token must fail.');
        } catch (BadRequestHttpException $exception) {
            $this->assertSame($content, file_get_contents($path));
            $this->assertFileDoesNotExist((new CacheService())->constructPath('replaced'));
        }
    }

    /** @return void Valid forms must still create a schema. */
    public function testValidTokenCanCreate(): void
    {
        $this->setRequest(['create' => '', 'name' => 'Valid Schema']);
        $this->createCrafter();

        $path = (new CacheService())->constructPath('valid_schema');
        $this->assertFileExists($path);
        $this->assertSame('Valid Schema', json_decode(file_get_contents($path), true)['name']);
    }
}
