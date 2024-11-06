<?php

namespace andy87\yii2\file_crafter\components\rules;

use Yii;
use yii\validators\UniqueValidator;
use andy87\yii2\file_crafter\components\models\SchemaDro;

/**
 * Class UniqueTableNameValidator
 *
 * @package andy87\yii2\file_crafter\components\rules
 *
 * @tag: #validator #unique #table #name
 */
class UniqueSchemaNameValidator extends UniqueValidator
{
    /**
     * @param SchemaDro $model
     * @param $attribute
     *
     * @return void
     */
    public function validateAttribute( $model, $attribute): void
    {
        $targetAttribute = $this->targetAttribute === null ? $attribute : $this->targetAttribute;

        if ($this->skipOnError) {
            foreach ((array)$targetAttribute as $k => $v) {
                if ($model->hasErrors(is_int($k) ? $v : $k)) {
                    return;
                }
            }
        }

        $cacheParams = $model->getParams();

        $cacheDir = Yii::getAlias($cacheParams['cacheDir']);
        $ext = $cacheParams['ext'];

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