<?php

namespace app\common\components\models;

use yii\base\Model;

/**
 * < Common > Информация о модели
 *
 * @package app\common\components\models
 *
 * @tag #common #modelInfo
 */
class ModelInfo
{
    /** @var string $modelName имя модели */
    public string $modelName;

    /** @var array $attributes атрибуты модели */
    public array $attributes = [];

    /** @var ?array $errors ошибки модели */
    public ?array $errors = null;



    /**
     * @param Model $model
     *
     * @param bool $runValidation
     */
    public function __construct(Model $model, bool $runValidation = true)
    {
        $this->modelName = get_class($model);

        $this->attributes = $model->attributes;

        if ($runValidation) $model->validate();

        $this->errors = $model->errors;
    }
}