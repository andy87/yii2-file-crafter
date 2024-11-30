<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\producers\items;

use Yii;
use Exception;
use yii\console\ExitCode;
use yii\base\InvalidConfigException;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\tests\unit\source\items\BaseUnitTest;
use app\common\components\base\producers\items\source\SourceProducer;

/**
 * < Common > Base Provider Test
 *
 * @package app\common\components\base\tests\unit
 *
 * @see BaseProducerTest::testCreateSuccess()
 * @see BaseProducerTest::testCreateSuccessWithSave()
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/provider/BaseProviderTest
 *
 * @tag: #abstract #base #test #producer
 */
abstract class BaseProducerTest extends BaseUnitTest
{
    /** @var array  */
    protected array $configProducer;


    /** @var SourceProducer */
    protected SourceProducer $producer;


    /** @var array */
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
        $this->setupProducer();
    }

    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    protected function setupProducer(): void
    {
        /** @var SourceProducer $producer */
        $producer = Yii::createObject($this->configProducer);

        $this->producer = $producer;

        $this->assertInstanceOf( SourceProducer::class, $this->producer );
    }

    /**
     * Проверка создания модели в runtime без сохранения
     *
     * @return int
     *
     * @throws Exception
     */
    public function testCreateSuccess(): int
    {
        /** @var SourceModel $model */
        $model = $this->producer->create($this->testParams['testCreateSuccess']);

        $this->assertInstanceOf( SourceModel::class, $model );

        $this->assertTrue( $model->isNewRecord );
        $this->assertFalse( $model->id );

        $model->validate();

        $this->assertFalse( $model->hasErrors() );

        return ExitCode::OK;
    }

    /**
     * Проверка сохранения модели в базу данных
     *
     * @return int
     *
     * @throws Exception
     */
    public function testCreateSuccessWithSave(): int
    {
        /** @var SourceModel $model */
        $model = $this->producer->create($this->testParams['testCreateSuccessWithSave'], true);

        $this->assertInstanceOf( SourceModel::class, $model );

        $this->assertFalse( $model->isNewRecord );
        $this->assertNotEmpty( $model->id );

        $model->validate();

        $this->assertFalse( $model->hasErrors() );

        return ExitCode::OK;
    }
}