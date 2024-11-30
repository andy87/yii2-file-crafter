<?php declare(strict_types=1);

namespace app\common\components\base\services\resources\crud;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\resources\items\BaseTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса представления в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @tag: #abstract #common #resource #base #crud #view
 */
abstract class BaseCrudViewResource extends BaseTemplateResource
{
    /** @var ?SourceModel */
    public ?SourceModel $model = null;
}