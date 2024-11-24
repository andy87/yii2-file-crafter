<?php declare(strict_types=1);

namespace app\common\components\core\tests\base\unit\providers;

use Yii, Exception;
use yii\base\InvalidConfigException;
use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\providers\items\base\CoreProvider;
use app\common\components\core\tests\base\unit\BaseUnitTest;

/**
 * < Common > Base Provider Test
 *
 * @package app\common\components\core\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/provider/BaseProviderTest
 *
 * @tag: #base #abstract #test #provider
 */
abstract class BaseProviderTest extends BaseUnitTest
{
    /** @var array  */
    protected array $configProvider;

    /** @var CoreProvider */
    protected CoreProvider $provider;

    protected array $testParams = [
        'testCreateSuccess' => [],
    ];



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    protected function setUp(): void
    {
        $this->setupProvider();
    }

    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    protected function setupProvider(): void
    {
        /** @var CoreProvider $provider */
        $provider = Yii::createObject($this->configProvider);

        $this->provider = $provider;

        $this->assertInstanceOf( CoreProvider::class, $this->provider );
    }

    /**
     * Проверка создания модели в runtime без сохранения
     *
     * @return bool
     *
     * @throws Exception
     */
    public function testCreateSuccess(): bool
    {
        /** @var BaseModel $model */
        $model = $this->provider->create($this->testParams['testCreateSuccess']);

        $this->assertFalse( is_null($model) );

        $this->assertInstanceOf( BaseModel::class, $model );

        $this->assertTrue( $model->isNewRecord );
        $this->assertFalse( $model->id );

        $model->validate();

        $this->assertFalse( $model->hasErrors() );

        return true;
    }

    /**
     * Проверка сохранения модели в базу данных
     *
     * @return bool
     *
     * @throws Exception
     */
    public function testCreateSuccessWithSave(): bool
    {
        /** @var BaseModel $model */
        $model = $this->provider->create($this->testParams['testCreateSuccessWithSave'], true);

        $this->assertFalse( is_null($model) );

        $this->assertInstanceOf( BaseModel::class, $model );

        $this->assertFalse( $model->isNewRecord );
        $this->assertNotEmpty( $model->id );

        $model->validate();

        $this->assertFalse( $model->hasErrors() );

        return true;
    }

}