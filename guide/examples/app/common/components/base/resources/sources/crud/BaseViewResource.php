<?php declare(strict_types=1);

namespace app\common\components\base\resources\sources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\resources\sources\BaseTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса представления в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @tag: #common #base #resource #view
 */
abstract class BaseViewResource extends BaseTemplateResource
{
    /** @var ?BaseModel */
    public ?BaseModel $model = null;
}