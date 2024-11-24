<?php declare(strict_types=1);

namespace app\common\components\base\resources\sources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\resources\sources\BaseTemplateResource;

/**
 * < Common > Базовый класс для ресурса с формой в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @tag: #common #base #resource #form
 */
abstract class BaseFormResource extends BaseTemplateResource
{
    /** @var ?BaseModel */
    public ?BaseModel $form = null;
}