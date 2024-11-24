<?php declare(strict_types=1);

namespace app\components\common\components\base\resources\sources\crud;

use yii\base\Model;

/**
 * < Common > Базовый класс для ресурса обновления данных в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @property Model $form
 *
 * @tag: #common #base #resource #update
 */
abstract class BaseUpdateResource extends BaseFormResource
{
    // {{Parent}}
}