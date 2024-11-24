<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use yii\base\Model;

/**
 * < Common > Базовый родительский класс для ресурса создания в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @property Model $form
 *
 * @tag: #common #base #resource #create
 */
abstract class BaseCreateResource extends BaseFormResource
{
    // {{Parent}}
}