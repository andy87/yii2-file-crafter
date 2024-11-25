<?php declare(strict_types=1);

namespace app\common\components\core\resources\sources\crud;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\resources\sources\CoreTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса представления в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\core\resources
 *
 * @tag: #core #abstract #common #resource #view
 */
abstract class CoreViewResource extends CoreTemplateResource
{
    /** @var ?BaseModel */
    public ?BaseModel $model = null;
}