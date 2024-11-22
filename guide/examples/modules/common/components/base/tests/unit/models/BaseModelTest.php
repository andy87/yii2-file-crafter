<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\models;

use yii\base\InvalidConfigException;
use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\tests\unit\core\BaseUnitTest;

/**
 * < Common > Base Model Test
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/models/BaseModelTest
 *
 * @tag: #base #test #model
 */
abstract class BaseModelTest extends BaseUnitTest
{
    /** @var BaseModel|string $modelClass */
    protected BaseModel|string $modelClass;



    /**
     * Проверка соответствия атрибутов модели и колонок таблицы
     *
     * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/models/BaseModelTest:testInspectAttributes
     *
     * @return bool
     *
     * @throws InvalidConfigException
     */
    public function testInspectAttributes(): bool
    {
        $modelClass = $this->modelClass;

        /** @var BaseModel $model */
        $model = new $modelClass();

        $attributes = array_keys($model->attributes());

        $columns = $model->getTableSchema()->columns;

        $this->assertEquals( $attributes, array_column($columns,'name') );

        $notNullColumns = array_filter($columns, function($column) {
            return !$column->allowNull;
        });

        $requiredAttributes = $this->getRequiredAttributes($model);

        foreach (array_column($notNullColumns, 'name') as $columnName )
        {
            $this->assertContains($columnName, $requiredAttributes);
        }

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