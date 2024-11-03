<?php

namespace andy87\yii2\dnk_file_crafter\components\rules;

use Yii;
use yii\validators\UniqueValidator;

/**
 * Class UniqueTableNameValidator
 *
 * @package andy87\yii2\dnk_file_crafter\components\rules
 *
 * @tag: #validator #unique #table #name
 */
class UniqueTableNameValidator extends UniqueValidator
{
    public array $paramsCache = [
        'cacheDir' => '@runtime/cache',
        'ext' => '.tpl',
    ];



    /**
     * @param $model
     * @param $attribute
     *
     * @return void
     */
    public function validateAttribute($model, $attribute): void
    {
        $targetAttribute = $this->targetAttribute === null ? $attribute : $this->targetAttribute;

        if ($this->skipOnError) {
            foreach ((array)$targetAttribute as $k => $v) {
                if ($model->hasErrors(is_int($k) ? $v : $k)) {
                    return;
                }
            }
        }

        $cacheDir = Yii::getAlias($this->paramsCache['cacheDir']);
        $ext = $this->paramsCache['ext'];

        $listFilePath = scandir("$cacheDir/*$ext");

        foreach ($listFilePath as $filePath)
        {
            $fileBaseName = pathinfo($filePath, PATHINFO_BASENAME);

            if ($fileBaseName === $model->$attribute) {
                $this->addError($model, $attribute, $this->message);
            }
        }
    }
}