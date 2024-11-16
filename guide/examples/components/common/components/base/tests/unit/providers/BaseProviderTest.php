<?php declare(strict_types=1);

namespace common\components\base\tests\unit;

use Yii;
use Exception;
use yii\base\InvalidConfigException;
use common\components\base\tests\core\BaseUnitTest;
use common\components\base\moels\items\core\BaseModel;
use common\components\base\providers\items\core\BaseProvider;

/**
 * Base Provider Test
 *
 * @package common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run common/components/base/tests/unit/provider/BaseProviderTest
 *
 * @tag: #base #test #provider
 */
abstract class BaseProviderTest extends BaseUnitTest
{

    /** @var array  */
    protected array $configProvider;

    /** @var BaseProvider */
    protected BaseProvider $provider;

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
        /** @var BaseProvider $provider */
        $provider = Yii::createObject($this->configProvider);

        $this->provider = $provider;

        $this->assertInstanceOf( BaseProvider::class, $this->provider );
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


    /**
     * Проверка соответствия атрибутов модели и колонок таблицы
     *
     * @return bool
     *
     * @throws Exception
     */
    public function testInspectAttributes(): bool
    {
        /** @var BaseModel $model */
        $model = $this->provider->create();

        $attributes = array_keys($model->attributes());

        $columns = $model->getTableSchema()->columns;

        $this->assertEquals( $attributes, array_column($columns,'name') );

        $notNullColumns = array_filter($columns, function($column) {
            return !$column->allowNull;
        });

        $requiredAttributes = $this->getRequiredAttributes($model);

        $this->assertEquals( $requiredAttributes, array_column($notNullColumns, 'name') );

        return true;
    }

    /**
     * @param BaseModel $model
     *
     * @return array
     */
    private function getRequiredAttributes( BaseModel $model ): array
    {
        $rules = $model->rules();

        $attributes = [];

        foreach ($rules as $rule) {
            if (is_array($rule) && $rule[1] === 'required') {
                $attributes = array_merge($attributes, $rule[0]);
            }
        }

        return $attributes;
    }
}